<?php

namespace App\Repositories;

use App\Models\Enrollment;
use App\Models\Course;
use App\Models\User;

class EnrollmentRepository
{
    /**
     * Get all enrollments
     */
    public function getAll()
    {
        return Enrollment::with(['user', 'course'])->get();
    }

    /**
     * Get a specific enrollment by ID
     */
    public function getById($id)
    {
        return Enrollment::with(['user', 'course'])->findOrFail($id);
    }

    /**
     * Enroll a user in a course
     */
    public function enroll(User $user, Course $course)
    {
        return Enrollment::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    /**
     * Check if a user is enrolled in a course
     */
    public function isEnrolled(User $user, Course $course): bool
    {
        return Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists();
    }

    /**
     * Unenroll a user from a course
     */
    public function unenroll(User $user, Course $course)
    {
        return Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->delete();
    }

    /**
     * Get all enrollments for a specific user
     */
    public function getUserEnrollments(User $user)
    {
        return Enrollment::where('user_id', $user->id)->with('course')->get();
    }
}
