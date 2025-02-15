<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobTitleStoreRequest;
use App\Http\Requests\JobTitleUpdateRequest;
use App\Models\JobTitle;
use App\Repositories\JobTitleRepository;
use Illuminate\Http\Request;

class JobTitleController extends Controller
{
    protected $jobTitleRepository;

    public function __construct(JobTitleRepository $jobTitleRepository) 
    {
        $this->jobTitleRepository = $jobTitleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobTitles = $this->jobTitleRepository->getAll();
        return view('job_titles.index', compact('jobTitles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job_titles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobTitleStoreRequest $request)
    {
        $this->jobTitleRepository->create($request->validated());
        return redirect()->route('job_titles.index')->with('success', 'Job Title created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobTitle $jobTitle) 
    {
        return view('job_titles.show', compact('jobTitle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobTitle $jobTitle) 
    {
        return view('job_titles.edit', compact('jobTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobTitleUpdateRequest $request, JobTitle $jobTitle) 
    {
        $this->jobTitleRepository->update($jobTitle, $request->validated());
        return redirect()->route('job_titles.index')->with('success', 'Job Title updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobTitle $jobTitle) 
    {
        $this->jobTitleRepository->delete($jobTitle);
        return redirect()->route('job_titles.index')->with('success', 'Job Title deleted successfully.');
    }
}
