<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Log;
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

        Log::log(
            Log::ACTION_VIEW_COMPANIES,
            ['Viewed all companies'],
            auth()->id()
        );

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

        Log::log(Log::ACTION_CREATE_COMPANY, [
            'id' => $company->id,
            'name' => $company->name,
            'slug' => $company->slug,
            'created_by' => $company->created_by,
        ], auth()->id());

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

        Log::log(Log::ACTION_SHOW_COMPANY, [
            'id' => $company->id,
            'name' => $company->name,
            'slug' => $company->slug,
        ], auth()->id());

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

        Log::log(Log::ACTION_UPDATE_COMPANY, [
            'id' => $company->id,
            'name' => $company->name,
            'slug' => $company->slug,
            'updated_by' => $company->updated_by,
        ], auth()->id());

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

        Log::log(Log::ACTION_DELETE_COMPANY, [
            'id' => $company->id,
            'name' => $company->name,
            'slug' => $company->slug,
            'deleted_by' => $company->deleted_by,
        ], auth()->id());

        return redirect()->route(
            'companies.index'
        )->with('success', 'Company deleted.');
    }

    public function restore(Company $company)
    {
        $company = Company::withTrashed()->findOrFail($company);
        $this->authorize('restore', $company);

        $company->restore();

        Log::log(Log::ACTION_REINSTATE_COMPANY, [
            'id' => $company->id,
            'name' => $company->name,
            'slug' => $company->slug,
        ], auth()->id());

        return redirect()->route(
            'companies.show',
            $company
        )->with('success', 'Company restored.');
    }
}
