<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Log;

class DepartmentLogger
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * Index method to log viewing all departments.
     */
    public function index(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_DEPARTMENTS,
            [
                'Viewed all departments',
            ],
            $userId,
        );
    }

    /**
     * Log showing a specific department.
     */
    public function show(Department $department, int $userId): array
    {
        return $this->log(
            Log::ACTION_SHOW_DEPARTMENT,
            [
                'id' => $department->id,
                'name' => $department->name,
                'slug' => $department->slug,
            ],
            $userId,
        );
    }

    /**
     * Log creating a new department.
     */
    public function create(Department $department, int $userId): array
    {
        return $this->log(
            Log::ACTION_CREATE_DEPARTMENT,
            [
                'id' => $department->id,
                'name' => $department->name,
                'slug' => $department->slug,
                'created_by' => $department->created_by,
                'created_at' => $department->created_at,
            ],
            $userId,
        );
    }

    /**
     * Log updating an existing company.
     */
    public function update(Department $department, int $userId): array
    {
        return $this->log(
            Log::ACTION_UPDATE_DEPARTMENT,
            [
                'id' => $department->id,
                'name' => $department->name,
                'slug' => $department->slug,
                'updated_by' => $department->updated_by,
                'updated_at' => $department->updated_at,
            ],
            $userId,
        );
    }

    /**
     * Log deleting a department.
     */
    public function delete(Department $department, int $userId): array
    {
        return $this->log(
            Log::ACTION_DELETE_DEPARTMENT,
            [
                'id' => $department->id,
                'name' => $department->name,
                'slug' => $department->slug,
                'deleted_by' => $department->deleted_by,
                'deleted_at' => $department->deleted_at,
            ],
            $userId,
        );
    }

    /**
     * Log restoring a department.
     */
    public function restore(Department $department, int $userId): array
    {
        return $this->log(
            Log::ACTION_REINSTATE_DEPARTMENT,
            [
                'id' => $department->id,
                'name' => $department->name,
                'slug' => $department->slug,
                'is_archived' => $department->is_archived,
                'restored_by' => $department->restored_by,
                'restored_at' => $department->restored_at,
            ],
            $userId,
        );
    }

    /**
     * Log viewing archived departments.
     */
    public function archived(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_ARCHIVED_DEPARTMENTS,
            [
                'Viewed archived departments',
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
