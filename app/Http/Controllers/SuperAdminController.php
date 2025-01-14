<?php

namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use App\Models\SalesPerson;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreSuperAdminRequest;
use App\Http\Requests\UpdateSuperAdminRequest;

class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreSuperAdminRequest $request)
    {

    //     $validator = Validator::make($request->all(), $request->rules());

    // if ($validator->fails()) {
    //     return response()->json([
    //         'message' => 'Validation failed.',
    //         'errors' => $validator->errors(),
    //     ], 422);
    // }
        $superAdmin = SuperAdmin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'employee_code' => $request->employee_code,
            'hire_date' => $request->hire_date,
            'sales_target' => $request->sales_target,
            'achieved_sales' => $request->achieved_sales,
        ]);
    
        // Add corresponding entry in sales_people table
        SalesPerson::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_name' => $request->user_name,
            'password' => Hash::make($request->password), // Hash the password
            'role' => 'super_admin',
        ]);
    
        return response()->json([
            'message' => 'Super Admin created successfully.',
            'super_admin' => $superAdmin,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuperAdminRequest $request, SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuperAdmin $superAdmin)
    {
        //
    }
}
