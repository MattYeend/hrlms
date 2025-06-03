<?php

namespace App\Services;

use App\Models\Log;
use App\Models\UserJob;

class UserJobLogger
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * Index method to log viewing all jobs.
     */
    public function index(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_JOBS,
            [
                'Viewed all jobs',
            ],
            $userId,
        );
    }

    /**
     * Log showing a specific job.
     */
    public function show(UserJob $userJob, int $userId): array
    {
        return $this->log(
            Log::ACTION_SHOW_JOB,
            [
                'id' => $userJob->id,
                'job_title' => $userJob->job_title,
                'email' => $userJob->email,
                'role_id' => $userJob->role_id,
                'department_id' => $userJob->department_id,
                'job_id' => $userJob->job_id,
            ],
            $userId
        );
    }

    /**
     * Log creating a new job.
     */
    public function create(UserJob $job, int $userId): array
    {
        return $this->log(
            Log::ACTION_CREATE_JOB,
            [
                'id' => $job->id,
                'job_title' => $job->name,
                'slug' => $job->slug,
                'short_code' => $job->short_code,
                'description' => $job->description,
                'is_default' => $job->is_default,
                'department_id' => $job->department_id,
                'created_by' => $job->created_by,
                'created_at' => $job->created_at,
            ],
            $userId,
        );
    }

    /**
     * Log updating an existing job.
     */
    public function update(UserJob $userJob, int $userId): array
    {
        return $this->log(
            Log::ACTION_UPDATE_JOB,
            [
                'id' => $userJob->id,
                'job_title' => $userJob->job_title,
                'slug' => $userJob->slug,
                'short_code' => $userJob->short_code,
                'description' => $userJob->description,
                'department_id' => $userJob->department_id,
                'updated_by' => $userJob->updated_by,
                'updated_at' => $userJob->updated_at,
            ],
            $userId,
        );
    }

    /**
     * Log deleting a job.
     */
    public function delete(UserJob $userJob, int $userId): array
    {
        return $this->log(
            Log::ACTION_DELETE_JOB,
            [
                'id' => $userJob->id,
                'job_title' => $userJob->job_title,
                'slug' => $userJob->slug,
                'short_code' => $userJob->short_code,
                'description' => $userJob->description,
                'department_id' => $userJob->department_id,
                'deleted_by' => $userJob->deleted_by,
                'deleted_at' => $userJob->deleted_at,
            ],
            $userId,
        );
    }

    /**
     * Log restoring a job.
     */
    public function restore(UserJob $job, int $userId): array
    {
        return $this->log(
            Log::ACTION_REINSTATE_JOB,
            [
                'id' => $job->id,
                'job_title' => $job->job_title,
                'slug' => $job->slug,
                'short_code' => $job->short_code,
                'description' => $job->description,
                'department_id' => $job->department_id,
                'restored_at' => $job->restored_at,
                'restored_by' => $job->restored_by,
            ],
            $userId,
        );
    }

    /**
     * Log viewing archived job.
     */
    public function archived(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_ARCHIVED_JOBS,
            [
                'Viewed archived jobs',
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
