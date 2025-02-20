<?php

namespace App\Repositories;

use App\Models\Enrollment;
use App\Models\Course;
use App\Models\User;

class EnrollmentRepository
{
    public function enroll(User $user, Course $course)
    {
        return Enrollment::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    public function isEnrolled(User $user, Course $course): bool
    {
        return Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists();
    }

    public function getUserEnrollments(User $user)
    {
        return Enrollment::where('user_id', $user->id)->with('course')->get();
    }
}
