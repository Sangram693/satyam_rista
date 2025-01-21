<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\SuperAdmin;
use App\Models\SalesPerson;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::all()->load('salesmen');

        return response()->json($admins);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['message' => 'Unauthorized: No authenticated user found'], 401);
        }
    
        if ($user->role !== 'super_admin') {
            return response()->json(['message' => 'You are not authorized to perform this action'], 403);
        }
    
        // Check if the super_admin exists before assigning the ID
        $superAdmin = SuperAdmin::where('email', $user->email)->first();
        if (!$superAdmin) {
            return response()->json(['message' => 'Super Admin record not found'], 404);
        }
    
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'employee_code' => $request->employee_code,
            'hire_date' => $request->hire_date,
            'sales_target' => $request->sales_target,
            'achieved_sales' => $request->achieved_sales,
            'super_admin_id' => $superAdmin->id,
            'created_by' => $user->id
        ]);
    
        SalesPerson::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_name' => $request->user_name,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);
    
        return response()->json([
            'message' => 'Admin created successfully.',
            'admin' => $admin,
        ]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show($admin)
    {

        $admin = Admin::find($admin)->load('salesmen');
        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        return response()->json($admin);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, $adminId)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized: No authenticated user found'], 401);
    }

    if ($user->role !== 'super_admin') {
        return response()->json(['message' => 'You are not authorized to perform this action'], 403);
    }

    // Check if the super_admin exists before assigning the ID
    $superAdmin = SuperAdmin::where('email', $user->email)->first();
    if (!$superAdmin) {
        return response()->json(['message' => 'Super Admin record not found'], 404);
    }

    // Ensure $adminId is properly converted into an Admin model
    $admin = Admin::find($adminId);
    if (!$admin) {
        return response()->json(['message' => 'Admin not found'], 404);
    }


    // Update only the provided fields
    $admin->update([
        'name' => $request->name ?? $admin->name,
        'email' => $request->email ?? $admin->email,
        'phone' => $request->phone ?? $admin->phone,
        'address' => $request->address ?? $admin->address,
        'employee_code' => $request->employee_code ?? $admin->employee_code,
        'hire_date' => $request->hire_date ?? $admin->hire_date,
        'sales_target' => $request->sales_target ?? $admin->sales_target,
        'achieved_sales' => $request->achieved_sales ?? $admin->achieved_sales,
        'super_admin_id' => $superAdmin->id ?? $admin->super_admin_id,
        'updated_by' => $user->id
    ]);

    return response()->json([
        'message' => 'Admin updated successfully.',
        'admin' => $admin,
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($adminId)
    {
        $admin = Admin::find($adminId);
        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $admin->delete();

        return response()->json(['message' => 'Admin deleted successfully']);
    }
}
