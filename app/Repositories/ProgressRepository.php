<?php

namespace App\Repositories;

use App\Models\Progress;
use App\Models\Course;
use App\Models\User;

class ProgressRepository
{
    public function trackProgress(User $user, Course $course, int $progress)
    {
        return Progress::updateOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['progress' => $progress]
        );
    }

    public function getUserProgress(User $user, Course $course)
    {
        return Progress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();
    }
}
