<?php

namespace App\Http\Controllers;

use App\Models\Salesman;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalesmanRequest;
use App\Http\Requests\UpdateSalesmanRequest;

class SalesmanController extends Controller
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
    public function store(StoreSalesmanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Salesman $salesman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salesman $salesman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesmanRequest $request, Salesman $salesman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salesman $salesman)
    {
        //
    }
}
