<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Bill::all()->load('dealerDistributor');

        return response()->json($bills);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function verify(Request $request, int $id)
    {
        $user = Auth::user();

        if($user->role !== 'super_admin' && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized: No authenticated user found'], 401);
        }

        $bill = Bill::find($id);

        if(!$bill) {
            return response()->json(['message' => 'Bill not found'], 404);
        }   

        $bill->is_verified = true;
        $bill->save();

        return response()->json([
            'message' => 'Bill verified successfully',
            'data' => $bill
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBillRequest $request)
    {
        $user = Auth::user();
        // return response()->json($user);

        $billFilePath = $request->hasFile('bill_file') 
        ? $request->file('bill_file')->store('uploads/bill_files', 'public') 
        : null;

        $bill = Bill::create([
            'invoice_number' => $request->invoice_number,
            'bill_file' => $billFilePath,
            'total_amount' => $request->total_amount,
            'status' => $request->status,
            'dealer_distributor_id' => $user->id,
        ]);



        return response()->json([
            'message' => 'Bill created successfully',
            'data' => $bill
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $bill = Bill::find($id);

        if(!$bill) {
            return response()->json(['message' => 'Bill not found'], 404);
        }

        return response()->json($bill);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBillRequest $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        //
    }
}
