<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository) 
    {
        $this->departmentRepository = $departmentRepository;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Department::class);
        $departments = $this->departmentRepository->getAll();
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Department::class);
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentStoreRequest $request) 
    {
        $this->authorize('create', Department::class);
        $this->departmentRepository->create($request->validated());
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $this->authorize('view', $department);
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department) 
    {
        $this->authorize('update', $department);
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentUpdateRequest $request, Department $department) 
    {
        $this->authorize('update', $department);

        $oldLead = $department->lead_id;
        $this->departmentRepository->update($department->id, $request->validated());
        
        $department->refresh();

        if ($oldLead !== $department->lead_id && $department->lead) {
            $department->lead->notify(new UserNotification(
                'department_lead_assigned',
                'You have been assigned as a department lead.',
                null,
                null,
                ['department_name' => $department->name]
            ));
        }

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department) 
    {
        $this->authorize('delete', $department);
        $this->departmentRepository->delete($department);
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
