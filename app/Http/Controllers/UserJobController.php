<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserJobRequest;
use App\Http\Requests\UpdateUserJobRequest;
use App\Models\Department;
use App\Models\Log;
use App\Models\User;
use App\Models\UserJob;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserJobController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(UserJob::class, 'job');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', UserJob::class);

        Log::log(Log::ACTION_VIEW_JOBS, ['Viewed all jobs'], auth()->id());

        $archivedCount = UserJob::onlyTrashed()->count();

        return Inertia::render('jobs/Index', [
            'jobs' => UserJob::with([
                'department:id,name',
            ])->get(),
            'departments' => Department::select('id', 'name')->get(),
            'authUser' => User::where(
                'id',
                auth()->id()
            )->with('role:id,name')->first(),
            'hasArchivedJobs' => $archivedCount > 0,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', UserJob::class);

        return Inertia::render('jobs/Create', [
            'departments' => Department::select('id', 'name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserJobRequest $request)
    {
        $this->authorize('create', UserJob::class);

        $data = $request->validated();
        $data['created_by'] = auth()->id();

        $job = UserJob::create($data);

        Log::log(Log::ACTION_CREATE_JOB, [
            'id' => $job->id,
            'job_title' => $job->name,
            'slug' => $job->slug,
            'short_code' => $job->short_code,
            'description' => $job->description,
            'is_default' => $job->is_default,
            'department_id' => $job->department_id,
            'created_by' => $job->created_by,
            'created_at' => $job->created_at,
        ], auth()->id());

        return redirect()->route('jobs.show', ['job' => $job->slug])
            ->with('success', 'Job created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserJob $userJob, Request $request)
    {
        $this->authorize('view', $userJob);

        $userJob->load(['department:id,name']);

        Log::log(Log::ACTION_SHOW_JOB, [
            'id' => $userJob->id,
            'job_title' => $userJob->job_title,
            'email' => $userJob->email,
            'role_id' => $userJob->role_id,
            'department_id' => $userJob->department_id,
            'job_id' => $userJob->job_id,
        ], auth()->id(), $userJob->id);

        return Inertia::render('jobs/Show', [
            'userJob' => $userJob,
            'departments' => Department::select('id', 'name')->get(),
            'from' => $request->query('from', 'index'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserJob $userJob)
    {
        $this->authorize('update', $userJob);

        return Inertia::render('jobs/Edit', [
            'job' => $userJob,
            'departments' => Department::select('id', 'name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserJobRequest $request, UserJob $userJob)
    {
        $this->authorize('update', $userJob);

        $data = $request->validated();
        $data['updated_by'] = auth()->id();

        $userJob->update($data);

        Log::log(Log::ACTION_UPDATE_JOB, [
            'id' => $userJob->id,
            'job_title' => $userJob->job_title,
            'slug' => $userJob->slug,
            'short_code' => $userJob->short_code,
            'description' => $userJob->description,
            'department_id' => $userJob->department_id,
            'updated_by' => $userJob->updated_by,
            'updated_at' => $userJob->updated_at,
        ], auth()->id());

        return redirect()->route('jobs.show', ['job' => $userJob->slug])
            ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserJob $userJob)
    {
        $this->authorize('delete', $userJob);

        $userJob->update(['deleted_by' => auth()->id(), 'delated_at' =>now(), 'is_archived' => true]);
        $userJob->delete();

        Log::log(Log::ACTION_DELETE_USER, [
            'id' => $userJob->id,
            'job_title' => $userJob->job_title,
            'slug' => $userJob->slug,
            'short_code' => $userJob->short_code,
            'description' => $userJob->description,
            'department_id' => $userJob->department_id,
            'deleted_by' => $userJob->deleted_by,
            'deleted_at' => $userJob->deleted_at,
        ], auth()->id());

        return redirect()->route('jobs.index')
            ->with('success', 'Job deleted successfully.');
    }

    public function restore(UserJob $job)
    {
        $this->authorize('restore', $job);

        $job->update([
            'deleted_at' => null,
            'deleted_by' => null,
            'is_archived' => false,
            'restored_at' => now(),
            'restored_by' => auth()->id(),
        ]);
        $job->restore();

        $this->restoreLog($job);

        return redirect()->route(
            'jobs.show',
            ['job' => $job->slug]
        )->with('success', 'Job restored.');
    }

    public function archived()
    {
        $this->authorize('viewArchived', UserJob::class);

        Log::log(
            Log::ACTION_VIEW_ARCHIVED_JOBS,
            ['Viewed archived jobs'],
            auth()->id()
        );

        return Inertia::render('jobs/Archived', [
            'jobs' => UserJob::onlyTrashed()->with([
                'department:id,name',
            ])->get(),
            'departments' => Department::select('id', 'name')->get(),
            'authUser' => User::where(
                'id',
                auth()->id()
            )->with('role:id,name')->first(),
        ]);
    }

    private function restoreLog(UserJob $userJob): array
    {
        $log = Log::log(Log::ACTION_REINSTATE_JOB, [
            'id' => $userJob->id,
            'job_title' => $userJob->job_title,
            'slug' => $userJob->slug,
            'short_code' => $userJob->short_code,
            'description' => $userJob->description,
            'department_id' => $userJob->department_id,
            'restored_at' => $userJob->restored_at,
            'restored_by' => $userJob->restored_by,
        ], auth()->id());

        return $log ?? [];
    }
}
