<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Salesman;
use App\Models\SuperAdmin;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreSalesmanRequest;
use App\Http\Requests\UpdateSalesmanRequest;

class SalesmanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesmen = Salesman::all()->makeHidden(['admin_id', 'created_by', 'updated_by'])->load('admin', 'dealerDistributors', 'zone', 'creator', 'updater');

        return response()->json($salesmen);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesmanRequest $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized: No authenticated user found'], 401);
        }

        

        $superAdmin = $user->role === 'super_admin' ? SuperAdmin::where('email', $user->email)->first() : null;
        $admin = $user->role === 'super_admin' ? Admin::find($request->admin_id) : Admin::where('email', $user->email)->first();

        if (!$admin && $user->role === 'super_admin') {
            return response()->json(['message' => 'Admin not found.'], 404);
        }

        // return response()->json(['admin_id' => $admin->id]);

        $salesman = Salesman::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'employee_code' => $request->employee_code,
            'zone' => $request->zone,
            'hire_date' => $request->hire_date,
            'sales_target' => $request->sales_target,
            'achieved_sales' => $request->achieved_sales,
            'admin_id' => $admin ? $admin->id : null,
            'created_by' => $user->id,
        ]);

        // Check if a SalesPerson already exists with this email
        if (!SalesPerson::where('email', $request->email)->exists()) {
            SalesPerson::create([
                'name' => $request->name,
                'email' => $request->email,
                'user_name' => $request->user_name,
                'password' => Hash::make($request->password),
                'role' => 'salesman',
            ]);
        }

        return response()->json([
            'message' => 'Salesman created successfully.',
            'salesman' => $salesman,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($salesmanId)
    {
        $salesman = Salesman::find($salesmanId);

        if (!$salesman) {
            return response()->json(['message' => 'Salesman not found.'], 404);
        }

        $salesman->makeHidden(['admin_id', 'created_by', 'updated_by'])->load('admin', 'dealerDistributors', 'zone', 'creator', 'updater');

        return response()->json($salesman);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesmanRequest $request, $salesmanId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized: No authenticated user found'], 401);
        }

        $superAdmin = $user->role === 'super_admin' ? SuperAdmin::where('email', $user->email)->first() : null;
        $admin = $user->role === 'super_admin' ? Admin::find($request->admin_id) : Admin::where('email', $user->email)->first();

        if (!$admin && $user->role === 'super_admin') {
            return response()->json(['message' => 'Admin not found.'], 404);
        }

        $salesman = Salesman::find($salesmanId);

        if (!$salesman) {
            return response()->json(['message' => 'Salesman not found.'], 404);
        }
        // return response()->json($salesman);

        $salesman->update([
            'name' => $request->name ?? $salesman->name,
            'email' => $request->email ?? $salesman->email,
            'phone' => $request->phone ?? $salesman->phone,
            'address' => $request->address ?? $salesman->address,
            'employee_code' => $request->employee_code ?? $salesman->employee_code,
            'zone' => $request->zone ?? $salesman->zone,
            'hire_date' => $request->hire_date ?? $salesman->hire_date,
            'status' => $request->status ?? $salesman->status,
            'sales_target' => $request->sales_target ?? $salesman->sales_target,
            'achieved_sales' => $request->achieved_sales ?? $salesman->achieved_sales,
            'admin_id' => $admin ? $admin->id : $salesman->admin_id,
            'updated_by' => $user->id,
        ]);

        return response()->json([
            'message' => 'Salesman updated successfully.',
            'salesman' => $salesman,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($salesmanId)
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['message' => 'Unauthorized: No authenticated user found'], 401);
        }
    
        if ($user->role !== 'super_admin' && $user->role !== 'admin') {
            return response()->json(['message' => 'You are not authorized to perform this action'], 403);
        }

        $salesman = Salesman::find($salesmanId);    

        if (!$salesman) {
            return response()->json(['message' => 'Salesman not found.'], 404);
        }

        $salesman->delete();

        return response()->json(['message' => 'Salesman deleted successfully.']);
    }
}
