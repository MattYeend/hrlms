<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Company::class);

        return Inertia::render('companies/Index', [
            'companies' => Company::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Company::class);

        return Inertia::render('companies/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $this->authorize('create', Company::class);

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['created_by'] = auth()->id();

        $company = Company::create($data);

        return redirect()->route(
            'companies.show',
            $company
        )->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $this->authorize('view', $company);

        return Inertia::render('companies/Show', ['company' => $company]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $this->authorize('update', $company);

        return Inertia::render('companies/Edit', ['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $this->authorize('update', $company);

        $data = $request->validated();
        $data['updated_by'] = auth()->id();

        $company->update($data);

        return redirect()->route(
            'companies.show',
            $company
        )->with('success', 'Company updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);

        $company->update(['deleted_by' => auth()->id()]);
        $company->delete();

        return redirect()->route(
            'companies.index'
        )->with('success', 'Company deleted.');
    }

    public function restore($id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $this->authorize('restore', $company);

        $company->restore();

        return redirect()->route(
            'companies.show',
            $company
        )->with('success', 'Company restored.');
    }
}
