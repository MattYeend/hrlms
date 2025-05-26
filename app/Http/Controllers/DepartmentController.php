<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Department::class, 'department');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Department::class);

        return Inertia::render('departments/Index', [
            'departments' => Department::get(),
            'authUser' => auth()->user()->load('role')->only('id', 'role'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Department::class);

        return Inertia::render('departments/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $this->authorize('create', Department::class);

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['created_by'] = auth()->id();

        $department = Department::create($data);

        return redirect()->route('departments.show', $department)
            ->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $this->authorize('view', $department);

        return Inertia::render('departments/Show', [
            'department' => $department,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $this->authorize('update', $department);
        return Inertia::render('departments/Edit', [
            'department' => $department,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateDepartmentRequest $request,
        Department $department
    ) {
        $this->authorize('update', $department);

        $data = $request->validated();
        $data['updated_by'] = auth()->id();

        $department->update($data);

        return redirect()->route('departments.show', $department)
            ->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);

        $department->update(['deleted_by' => auth()->id()]);
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    public function restore($id)
    {
        $department = Department::withTrashed()->findOrFail($id);
        $this->authorize('restore', $department);

        $department->restore();

        return redirect()->route(
            'departments.show',
            $department
        )->with('success', 'Department restored.');
    }
}
