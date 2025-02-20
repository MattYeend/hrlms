<?php

namespace App\Repositories;

use App\Models\Progress;
use App\Models\Course;
use App\Models\User;

class ProgressRepository
{
    /**
     * Get all progress records.
     */
    public function getAll()
    {
        return Progress::with(['user', 'course'])->get();
    }

    /**
     * Get a specific progress record by ID.
     */
    public function getById($id)
    {
        return Progress::with(['user', 'course'])->findOrFail($id);
    }

    /**
     * Track or update progress for a user in a course.
     */
    public function trackProgress(User $user, Course $course, int $progress)
    {
        return Progress::updateOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['progress' => $progress]
        );
    }

    /**
     * Get a user's progress in a specific course.
     */
    public function getUserProgress(User $user, Course $course)
    {
        return Progress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();
    }
}
