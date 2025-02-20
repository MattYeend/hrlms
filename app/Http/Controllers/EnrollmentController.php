<?php

namespace App\Http\Controllers;

use App\Repositories\EnrollmentRepository;
use App\Repositories\CourseRepository;
use App\Http\Requests\StoreEnrollmentRequest;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    protected $enrollmentRepository;
    protected $courseRepository;

    public function __construct(EnrollmentRepository $enrollmentRepository, CourseRepository $courseRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->courseRepository = $courseRepository;
        $this->middleware('auth');
    }

    /**
     * Display a list of enrollments.
     */
    public function index()
    {
        $enrollments = $this->enrollmentRepository->getAll();
        return view('enrollments.index', compact('enrollments'));
    }

    /**
     * Show details of a specific enrollment.
     */
    public function show($id)
    {
        $enrollment = $this->enrollmentRepository->getById($id);
        return view('enrollments.show', compact('enrollment'));
    }

    /**
     * Enroll a user in a course.
     */
    public function enroll(StoreEnrollmentRequest $request, $courseId)
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
     * Unenroll a user from a course.
     */
    public function unenroll(Request $request, $courseId)
    {
        $user = auth()->user();
        $course = $this->courseRepository->getById($courseId);

        if (!$this->enrollmentRepository->isEnrolled($user, $course)) {
            return redirect()->back()->with('error', 'You are not enrolled in this course.');
        }

        $this->enrollmentRepository->unenroll($user, $course);
        return redirect()->route('courses.show', $courseId)->with('success', 'Unenrolled successfully.');
    }
}
