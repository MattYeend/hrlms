<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\CompanyLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CompanyController extends Controller
{
    protected CompanyLogger $logger;

    public function __construct(CompanyLogger $logger)
    {
        $this->authorizeResource(Company::class, 'company');
        $this->logger = $logger;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Company::class);

        $this->logger->index(auth()->id());

        $archivedCount = Company::onlyTrashed()->count();

        return Inertia::render('companies/Index', [
            'companies' => Company::all(),
            'authUser' => [
                'id' => auth()->user()->id,
                'role' => [
                    'name' => auth()->user()->role->name,
                ],
            ],
            'hasArchivedCompanies' => $archivedCount > 0,
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

        $this->logger->create($company, auth()->id());

        return redirect()->route(
            'companies.show',
            $company
        )->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Request $request)
    {
        $this->authorize('view', $company);

        $this->logger->show($company, auth()->id());

        return Inertia::render('companies/Show', [
            'company' => $company,
            'from' => $request->query('from', 'index'),
        ]);
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

        $this->logger->update($company, auth()->id());

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

        $company->update([
            'deleted_by' => auth()->id(),
            'delated_at' => now(),
            'is_archived' => true,
        ]);
        $company->delete();

        $this->logger->delete($company, auth()->id());

        return redirect()->route(
            'companies.index'
        )->with('success', 'Company deleted.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company)
    {
        $this->authorize('restore', $company);

        $company->update([
            'deleted_at' => null,
            'deleted_by' => null,
            'is_archived' => false,
            'restored_at' => now(),
            'restored_by' => auth()->id(),
        ]);

        $company->restore();

        $this->logger->restore($company, auth()->id());

        return redirect()->route(
            'companies.show',
            $company
        )->with('success', 'Company restored.');
    }

    /**
     * Display a listing of archived companies.
     */
    public function archived()
    {
        $this->authorize('viewArchived', Company::class);

        $this->logger->archived(auth()->id());

        return Inertia::render('companies/Archived', [
            'companies' => Company::onlyTrashed()->get(),
            'authUser' => [
                'id' => auth()->user()->id,
                'role' => [
                    'name' => auth()->user()->role->name,
                ],
            ],
        ]);
    }
}
