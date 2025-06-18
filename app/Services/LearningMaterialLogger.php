<?php

namespace App\Services;

use App\Models\LearningMaterial;
use App\Models\Log;

class LearningMaterialLogger
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * Index method to log viewing all learning materials.
     */
    public function index(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_LEARNING_MATERIALS,
            [
                'Viewed all learning materials',
            ],
            $userId,
        );
    }

    /**
     * Log showing a specific learning material.
     */
    public function show(
        LearningMaterial $learningMaterial,
        int $userId
    ): array {
        return $this->log(
            Log::ACTION_SHOW_LEARNING_MATERIAL,
            [
                'id' => $learningMaterial->id,
                'title' => $learningMaterial->name,
                'slug' => $learningMaterial->slug,
            ],
            $userId,
        );
    }

    /**
     * Log creating a new learning material.
     */
    public function create(
        LearningMaterial $learningMaterial,
        int $userId
    ): array {
        return $this->log(
            Log::ACTION_CREATE_LEARNING_MATERIAL,
            [
                'id' => $learningMaterial->id,
                'title' => $learningMaterial->title,
                'slug' => $learningMaterial->slug,
                'created_by' => $learningMaterial->created_by,
                'created_at' => $learningMaterial->created_at,
            ],
            $userId,
        );
    }

    /**
     * Log updating an existing learning material.
     */
    public function update(
        LearningMaterial $learningMaterial,
        int $userId
    ): array {
        return $this->log(
            Log::ACTION_UPDATE_LEARNING_MATERIAL,
            [
                'id' => $learningMaterial->id,
                'title' => $learningMaterial->title,
                'slug' => $learningMaterial->slug,
                'updated_by' => $learningMaterial->updated_by,
                'updated_at' => $learningMaterial->updated_at,
            ],
            $userId,
        );
    }

    /**
     * Log deleting a learning provider.
     */
    public function delete(
        LearningMaterial $learningMaterial,
        int $userId
    ): array {
        return $this->log(
            Log::ACTION_DELETE_LEARNING_MATERIAL,
            [
                'id' => $learningMaterial->id,
                'title' => $learningMaterial->title,
                'slug' => $learningMaterial->slug,
                'deleted_by' => $learningMaterial->deleted_by,
                'deleted_at' => $learningMaterial->deleted_at,
            ],
            $userId,
        );
    }

    /**
     * Log restoring a learning provider.
     */
    public function restore(
        LearningMaterial $learningMaterial,
        int $userId
    ): array {
        return $this->log(
            Log::ACTION_REINSTATE_LEARNING_MATERIAL,
            [
                'id' => $learningMaterial->id,
                'title' => $learningMaterial->title,
                'slug' => $learningMaterial->slug,
                'is_archived' => $learningMaterial->is_archived,
                'restored_by' => $learningMaterial->restored_by,
                'restored_at' => $learningMaterial->restored_at,
            ],
            $userId,
        );
    }

    /**
     * Log viewing archived learning materials.
     */
    public function archived(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_ARCHIVED_LEARNING_MATERIALS,
            [
                'Viewed archived learning materials',
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

