<?php

namespace App\Services;

use App\Models\Log;
use App\Models\Quiz;

class QuizLogger
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * Index method to log viewing all quizzes.
     */
    public function index(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_QUIZZES,
            [
                'Viewed all quizzes',
            ],
            $userId,
        );
    }

    /**
     * Log showing a specific quiz.
     */
    public function show(Quiz $quiz, int $userId): array
    {
        return $this->log(
            Log::ACTION_SHOW_QUIZ,
            [
                'id' => $quiz->id,
                'job_title' => $quiz->job_title,
                'email' => $quiz->email,
                'role_id' => $quiz->role_id,
                'department_id' => $quiz->department_id,
                'job_id' => $quiz->job_id,
            ],
            $userId
        );
    }

    /**
     * Log creating a new quiz.
     */
    public function create(Quiz $quiz, int $userId): array
    {
        return $this->log(
            Log::ACTION_CREATE_QUIZ,
            [
                'id' => $quiz->id,
                'job_title' => $quiz->name,
                'slug' => $quiz->slug,
                'short_code' => $quiz->short_code,
                'description' => $quiz->description,
                'is_default' => $quiz->is_default,
                'department_id' => $quiz->department_id,
                'created_by' => $quiz->created_by,
                'created_at' => $quiz->created_at,
            ],
            $userId,
        );
    }

    /**
     * Log updating an existing quiz.
     */
    public function update(Quiz $quiz, int $userId): array
    {
        return $this->log(
            Log::ACTION_UPDATE_QUIZ,
            [
                'id' => $quiz->id,
                'job_title' => $quiz->job_title,
                'slug' => $quiz->slug,
                'short_code' => $quiz->short_code,
                'description' => $quiz->description,
                'department_id' => $quiz->department_id,
                'updated_by' => $quiz->updated_by,
                'updated_at' => $quiz->updated_at,
            ],
            $userId,
        );
    }

    /**
     * Log deleting a quiz.
     */
    public function delete(Quiz $quiz, int $userId): array
    {
        return $this->log(
            Log::ACTION_DELETE_QUIZ,
            [
                'id' => $quiz->id,
                'job_title' => $quiz->job_title,
                'slug' => $quiz->slug,
                'short_code' => $quiz->short_code,
                'description' => $quiz->description,
                'department_id' => $quiz->department_id,
                'deleted_by' => $quiz->deleted_by,
                'deleted_at' => $quiz->deleted_at,
            ],
            $userId,
        );
    }

    /**
     * Log restoring a quiz.
     */
    public function restore(Quiz $quiz, int $userId): array
    {
        return $this->log(
            Log::ACTION_REINSTATE_QUIZ,
            [
                'id' => $quiz->id,
                'job_title' => $quiz->job_title,
                'slug' => $quiz->slug,
                'short_code' => $quiz->short_code,
                'description' => $quiz->description,
                'department_id' => $quiz->department_id,
                'restored_at' => $quiz->restored_at,
                'restored_by' => $quiz->restored_by,
            ],
            $userId,
        );
    }

    /**
     * Log viewing archived quiz.
     */
    public function archived(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_ARCHIVED_QUIZZES,
            [
                'Viewed archived quizzes',
            ],
            $userId,
        );
    }

    /**
     * Helper method to log actions.
     */
    private function log(string $action, array $data, int $userId): array
    {
        $log = Log::log($action, $data, $userId);
        return is_array($log) ? $log : [];
    }
}
