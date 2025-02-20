<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Repositories\CourseRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\ProgressRepository;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $courseRepository;
    protected $enrollmentRepository;
    protected $progressRepository;

    public function __construct(CourseRepository $courseRepository, EnrollmentRepository $enrollmentRepository, ProgressRepository $progressRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->progressRepository = $progressRepository;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = $this->courseRepository->getAll();
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $this->courseRepository->create($request->validated());
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $course = $this->courseRepository->getById($id);
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $course = $this->courseRepository->getById($id);
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, $id)
    {
        $this->courseRepository->update($id, $request->validated());
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->courseRepository->delete($id);
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    /**
     * Enroll a user in a course.
     */
    public function enroll(Request $request, $courseId)
    {
        $user = auth()->user();
        $course = $this->courseRepository->getById($courseId);

        if ($this->enrollmentRepository->isEnrolled($user, $course)) {
            return redirect()->back()->with('error', 'You are already enrolled in this course.');
        }

        $this->enrollmentRepository->enroll($user, $course);
        return redirect()->route('courses.show', $courseId)->with('success', 'Enrolled successfully.');
    }

    /**
     * Track user progress in a course.
     */
    public function trackProgress(Request $request, $courseId)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $user = auth()->user();
        $course = $this->courseRepository->getById($courseId);

        $this->progressRepository->trackProgress($user, $course, $request->progress);
        return redirect()->route('courses.show', $courseId)->with('success', 'Progress updated.');
    }
}
