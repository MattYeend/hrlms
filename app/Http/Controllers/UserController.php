<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Department;
use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use App\Models\UserJob;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        Log::log(Log::ACTION_VIEW_USERS, ['Viewed all users'], auth()->id());

        $archivedCount = User::onlyTrashed()->count();

        return Inertia::render('users/Index', [
            'users' => User::with([
                'role:id,name',
                'department:id,name',
                'job:id,job_title',
            ])->get(),
            'roles' => Role::select('id', 'name')->get(),
            'departments' => Department::select('id', 'name')->get(),
            'authUser' => User::where(
                'id',
                auth()->id()
            )->with('role:id,name')->first(),
            'hasArchivedUsers' => $archivedCount > 0,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return Inertia::render('users/Create', [
            'roles' => Role::select('id', 'name')->get(),
            'departments' => Department::select('id', 'name')->get(),
            'jobs' => UserJob::select('id', 'job_title')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validated();
        $data['created_by'] = auth()->id();

        $user = User::create($data);

        Log::log(Log::ACTION_CREATE_USER, [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'department_id' => $user->department_id,
            'created_by' => $user->created_by,
            'created_at' => $user->created_at,
        ], auth()->id(), $user->id);

        return redirect()->route('users.show', $user)
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Request $request)
    {
        $this->authorize('view', $user);

        $user->load(['role:id,name', 'department:id,name', 'job:id,job_title']);

        Log::log(Log::ACTION_SHOW_USER, [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'department_id' => $user->department_id,
            'job_id' => $user->job_id,
        ], auth()->id(), $user->id);

        return Inertia::render('users/Show', [
            'user' => $user,
            'roles' => Role::select('id', 'name')->get(),
            'departments' => Department::select('id', 'name')->get(),
            'jobs' => UserJob::select('id', 'job_title')->get(),
            'from' => $request->query('from', 'index'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return Inertia::render('users/Edit', [
            'user' => $user,
            'roles' => Role::select('id', 'name')->get(),
            'departments' => Department::select('id', 'name')->get(),
            'jobs' => UserJob::select('id', 'job_title')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateUserRequest $request,
        User $user
    ) {
        $this->authorize('update', $user);

        $data = $request->validated();
        $data['updated_by'] = auth()->id();

        $user->update($data);

        Log::log(Log::ACTION_UPDATE_USER, [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'department_id' => $user->department_id,
            'job_id' => $user->job_id,
            'updated_by' => $user->updated_by,
            'updated_at' => $user->updated_at,
        ], auth()->id(), $user->id);

        return redirect()->route('users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->update([
            'deleted_by' => auth()->id(),
            'deleted_at' => now(),
            'is_archived' => true,
        ]);
        $user->delete();

        Log::log(Log::ACTION_DELETE_USER, [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'department_id' => $user->department_id,
            'job_id' => $user->job_id,
            'deleted_by' => $user->deleted_by,
            'deleted_at' => $user->deleted_at,
        ], auth()->id(), $user->id);

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function restore(User $user)
    {
        $this->authorize('restore', $user);

        $user->update([
            'deleted_at' => null,
            'deleted_by' => null,
            'is_archived' => false,
            'restored_at' => now(),
            'restored_by' => auth()->id(),
        ]);
        $user->restore();

        $this->restoreLog($user);

        return redirect()->route(
            'users.show',
            $user
        )->with('success', 'User restored.');
    }

    public function archived()
    {
        $this->authorize('viewArchived', User::class);
        $archivedUsers = User::onlyTrashed()
            ->with(['role:id,name', 'department:id,name', 'job:id,job_title'])
            ->get();

        $roles = Role::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();
        $jobs = UserJob::select('id', 'job_title')->get();

        $authUser = User::where('id', auth()->id())
            ->with('role:id,name')
            ->first();

        $this->archivedLog($authUser);

        return Inertia::render('users/Archived', [
            'users' => $archivedUsers,
            'roles' => $roles,
            'departments' => $departments,
            'jobs' => $jobs,
            'authUser' => $authUser,
        ]);
    }

    private function archivedLog(User $user): array
    {
        $log = Log::log(Log::ACTION_VIEW_ARCHIVED_USERS, [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'department_id' => $user->department_id,
            'job_id' => $user->job_id,
            'deleted_by' => $user->deleted_by,
            'deleted_at' => $user->deleted_at,
        ], auth()->id(), $user->id);
        return is_array($log) ? $log : [];
    }

    private function restoreLog(User $user): array
    {
        $log = Log::log(Log::ACTION_REINSTATE_USER, [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'department_id' => $user->department_id,
            'job_id' => $user->job_id,
            'restored_at' => $user->restored_at,
            'restored_by' => $user->restored_by,
        ], auth()->id(), $user->id);

        return $log ?? [];
    }
}
