<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;

class RoleController extends Controller
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
    public function store(StoreRoleRequest $request)
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Empty, as this needs to be updated in due course
    }
}
