<?php

namespace App\Http\Controllers;

use App\Models\Salesman;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DealerDistributor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreDealerDistributorRequest;
use App\Http\Requests\UpdateDealerDistributorRequest;

class DealerDistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display the specified resource.
     */
    public function index()
    {
        $dealerDistributors = DealerDistributor::all()->load('salesman', 'zone');

        return response()->json($dealerDistributors);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_name' => 'required',
            'password' => 'required',
        ],[
            'user_name.required'=>'User Name is required',
            'password.required'=>'Password is required'
        ]);

        $dealerDistributor = DealerDistributor::where('username', $credentials['user_name'])->first();

        if (!$dealerDistributor) {
            return response()->json(['message' => 'Dealer Distributor not found.'], 404);
        }

        if (!$dealerDistributor->is_verified) {
            return response()->json([
                'message' => 'Your account not verified yet. Please contact admin.'
            ], 401);
        }

        if ($dealerDistributor && Hash::check($credentials['password'], $dealerDistributor->password)) {
            $token = $dealerDistributor->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'data' => $dealerDistributor,
                'token' => $token
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function logout(Request $request)
    {

        // return response()->json($request->user());
        $request->user()->currentAccessToken()->delete();

        

        return response()->json(['message' => 'Logout successful']);
    }

    public function verify(Request $request, int $id)
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized: No authenticated user found'], 401);
        }

        $dealerDistributor = DealerDistributor::find($id);
        if (!$dealerDistributor) {
            return response()->json(['message' => 'Dealer or Distributor not found.'], 404);
        }


        $dealerDistributor->is_verified = true;
        $dealerDistributor->save();

        return response()->json([
            'message' => 'Account verified successfully.',
            'data' => $dealerDistributor
        ]);
    }

public function store(StoreDealerDistributorRequest $request)
{
    $user = Auth::user();

    $isVerify = false;

    $salesman = $user->role ==='salesman' ? 
    Salesman::where('email', $user->email)->first() 
    : Salesman::find($request->salesman_id);
    $isVerify = $user->role ==='salesman' ? false : true;

    // Handle File Uploads
    $bankStatementPath = $request->hasFile('bank_statement') 
        ? $request->file('bank_statement')->store('uploads/bank_statements', 'public') 
        : null;

    $gstCertificatePath = $request->hasFile('gst_certificate') 
        ? $request->file('gst_certificate')->store('uploads/gst_certificates', 'public') 
        : null;

        // return response()->json($salesman);

    // Create Dealer Distributor Record
    $dealerDistributor = DealerDistributor::create([
        'bank_statement' => $bankStatementPath,
        'gst_certificate' => $gstCertificatePath,
        'gstin' => $request->gstin,
        'did' => $request->did,
        'name' => $request->name,
        'phone_number' => $request->phone_number,
        'email' => $request->email,
        'username' => $request->user_name,
        'password' => Hash::make($request->password),
        'address' => $request->address,
        'gstin' => $request->gstin,
        'zone' => $request->zone,
        'pan_card' => $request->pan_card,
        'is_verified' => $isVerify,
        'type' => $request->type,
        'salesman_id' => $salesman->id
    ]);

    return response()->json([
        'message' => Str::ucfirst($request->type).' created successfully.',
        'data' => $dealerDistributor
    ]);

}

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {

        $dealerDistributor = DealerDistributor::find($id);

        if (!$dealerDistributor) {
            return response()->json(['message' => 'Dealer or Distributor not found.'], 404);
        }

        $dealerDistributor->load('salesman', 'zone');

        return response()->json($dealerDistributor);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDealerDistributorRequest $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
    }
}
