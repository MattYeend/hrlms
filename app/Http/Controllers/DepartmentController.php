<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
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

        Log::log(
            Log::ACTION_VIEW_DEPARTMENTS,
            ['Viewed all departments'],
            auth()->id()
        );

        $archivedCount = Department::onlyTrashed()->count();

        return Inertia::render('departments/Index', [
            'departments' => Department::with('deptLead')
                ->withCount('users')
                ->get(),
            'authUser' => auth()->user()->load('role')->only('id', 'role'),
            'hasArchivedDepartments' => $archivedCount > 0,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Department::class);

        return Inertia::render('departments/Create', [
            'users' => User::select('id', 'name')->get(),
        ]);
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

        Log::log(Log::ACTION_CREATE_DEPARTMENT, [
            'id' => $department->id,
            'name' => $department->name,
            'slug' => $department->slug,
            'created_by' => $department->created_by,
            'created_at' => $department->created_at,
        ], auth()->id());
        return redirect()->route('departments.show', $department)
            ->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department, Request $request)
    {
        $this->authorize('view', $department);

        Log::log(Log::ACTION_SHOW_DEPARTMENT, [
            'id' => $department->id,
            'name' => $department->name,
            'slug' => $department->slug,
        ], auth()->id());

        return Inertia::render('departments/Show', [
            'department' => $department->load('deptLead'),
            'from' => $request->query('from', 'index'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $this->authorize('update', $department);
        return Inertia::render('departments/Edit', [
            'department' => $department->load('deptLead'),
            'users' => User::select('id', 'name')->get(),
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

        Log::log(Log::ACTION_UPDATE_DEPARTMENT, [
            'id' => $department->id,
            'name' => $department->name,
            'slug' => $department->slug,
            'updated_by' => $department->updated_by,
            'updated_at' => $department->updated_at,
        ], auth()->id());

        return redirect()->route('departments.show', $department)
            ->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);

        $department->update(['deleted_by' => auth()->id(), 'archived' => true]);
        $department->delete();

        Log::log(Log::ACTION_DELETE_DEPARTMENT, [
            'id' => $department->id,
            'name' => $department->name,
            'slug' => $department->slug,
            'deleted_by' => $department->deleted_by,
            'deleted_at' => $department->deleted_at,
        ], auth()->id());

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    public function restore(Department $department)
    {
        $this->authorize('restore', $department);

        $department->update([
            'deleted_by' => null,
            'archived' => false,
            'restored_at' => now(),
            'restored_by' => auth()->id(),
        ]);
        $department->restore();

        $this->restoreLog($department);

        return redirect()->route(
            'departments.show',
            $department
        )->with('success', 'Department restored.');
    }

    public function archived()
    {
        $this->authorize('viewArchived', Department::class);

        Log::log(
            Log::ACTION_VIEW_ARCHIVED_DEPARTMENTS,
            ['Viewed archived departments'],
            auth()->id()
        );

        return Inertia::render('departments/Archived', [
            'departments' => Department::onlyTrashed()
                ->with('deptLead')
                ->withCount('users')
                ->get(),
            'authUser' => auth()->user()->load('role')->only('id', 'role'),
        ]);
    }

    private function restoreLog($department)
    {
        return Log::log(Log::ACTION_REINSTATE_DEPARTMENT, [
            'id' => $department->id,
            'name' => $department->name,
            'slug' => $department->slug,
            'restored_at' => $department->restored_at,
            'restored_by' => $department->restored_by,
        ], auth()->id());
    }
}
