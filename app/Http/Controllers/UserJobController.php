<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserJobRequest;
use App\Http\Requests\UpdateUserJobRequest;
use App\Models\Department;
use App\Models\User;
use App\Models\UserJob;
use App\Services\UserJobLogger;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserJobController extends Controller
{
    protected UserJobLogger $logger;

    public function __construct(UserJobLogger $logger)
    {
        $this->authorizeResource(UserJob::class, 'job');
        $this->logger = $logger;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', UserJob::class);

        $this->logger->index(auth()->id());

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

        $this->logger->create($job, auth()->id());

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

        $this->logger->show($userJob, auth()->id());

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

        $this->logger->update($userJob, auth()->id());

        return redirect()->route('jobs.show', ['job' => $userJob->slug])
            ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserJob $userJob)
    {
        $this->authorize('delete', $userJob);

        $userJob->update([
            'deleted_by' => auth()->id(),
            'delated_at' => now(),
            'is_archived' => true,
        ]);
        $userJob->delete();

        $this->logger->delete($userJob, auth()->id());

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

        $this->logger->restore($job, auth()->id());

        return redirect()->route(
            'jobs.show',
            ['job' => $job->slug]
        )->with('success', 'Job restored.');
    }

    public function archived()
    {
        $this->authorize('viewArchived', UserJob::class);

        $this->logger->archived(auth()->id());

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
}
