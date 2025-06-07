<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\User;
use App\Services\DepartmentLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    protected DepartmentLogger $logger;

    public function __construct(DepartmentLogger $logger)
    {
        $this->authorizeResource(Department::class, 'department');
        $this->logger = $logger;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Department::class);

        $this->logger->index(auth()->id());

        $user = auth()->user()->load('role');

        $archivedCount = Department::onlyTrashed()->count();

        return Inertia::render('departments/Index', [
            'departments' => Department::with('deptLead')
                ->withCount('users')
                ->get(),
            'authUser' => [
                'id' => $user->id,
                'role' => $user->role->only('name'),
                'isHighLevelStaff' => $user->isHighLevelStaff(),
            ],
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

        $this->logger->create($department, auth()->id());

        return redirect()->route('departments.show', $department)
            ->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department, Request $request)
    {
        $this->authorize('view', $department);

        $this->logger->show($department, auth()->id());

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

        $this->logger->update($department, auth()->id());

        return redirect()->route('departments.show', $department)
            ->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);

        $department->update([
            'deleted_by' => auth()->id(),
            'deleted_at' => now(),
            'is_archived' => true,
        ]);
        $department->delete();

        $this->logger->delete($department, auth()->id());

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    public function restore(Department $department)
    {
        $this->authorize('restore', $department);

        $department->update([
            'deleted_at' => null,
            'deleted_by' => null,
            'is_archived' => false,
            'restored_at' => now(),
            'restored_by' => auth()->id(),
        ]);
        $department->restore();

        $this->logger->restore($department, auth()->id());

        return redirect()->route(
            'departments.show',
            $department
        )->with('success', 'Department restored.');
    }

    public function archived()
    {
        $this->authorize('viewArchived', Department::class);

        $this->logger->archived(auth()->id());

        return Inertia::render('departments/Archived', [
            'departments' => Department::onlyTrashed()
                ->with('deptLead')
                ->withCount('users')
                ->get(),
            'authUser' => auth()->user()->load('role')->only('id', 'role'),
        ]);
    }
}
