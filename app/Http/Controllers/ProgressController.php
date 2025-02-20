<?php

namespace App\Http\Controllers;

use App\Repositories\ProgressRepository;
use App\Repositories\CourseRepository;
use App\Http\Requests\StoreProgressRequest;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    protected $progressRepository;
    protected $courseRepository;

    public function __construct(ProgressRepository $progressRepository, CourseRepository $courseRepository)
    {
        $this->progressRepository = $progressRepository;
        $this->courseRepository = $courseRepository;
        $this->middleware('auth');
    }

    /**
     * Display a list of progress records.
     */
    public function index()
    {
        $progressRecords = $this->progressRepository->getAll();
        return view('progress.index', compact('progressRecords'));
    }

    /**
     * Show a specific progress record.
     */
    public function show($id)
    {
        $progress = $this->progressRepository->getById($id);
        return view('progress.show', compact('progress'));
    }

    /**
     * Track progress for a user in a course.
     */
    public function trackProgress(StoreProgressRequest $request, $courseId)
    {
        $user = auth()->user();
        $course = $this->courseRepository->getById($courseId);

        $this->progressRepository->trackProgress($user, $course, $request->validated()['progress']);
        return redirect()->route('courses.show', $courseId)->with('success', 'Progress updated.');
    }
}
