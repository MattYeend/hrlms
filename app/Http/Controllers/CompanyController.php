<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
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
    public function store(StoreCompanyRequest $request)
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        // Empty, as this needs to be updated in due course
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // Empty, as this needs to be updated in due course
    }
}
