<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseRepository
{
    public function __construct()
    {
        //
    }

    public function getAll(): Collection
    {
        return Course::where('status', 'published')->get();
    }

    public function getById(int $id): ?Course
    {
        return Course::findOrFail($id);
    }

    public function create(array $data): Course
    {
        return Course::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $course = Course::findOrFail($id);
        return $course->update($data);
    }

    public function delete(int $id): bool
    {
        $course = Course::findOrFail($id);
        return $course->delete();
    }
}
