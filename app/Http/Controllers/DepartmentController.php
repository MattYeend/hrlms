<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateDepartmentRequest $request,
        Department $department
    ) {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        // Empty, as this needs to be updated in due course
    }
}
