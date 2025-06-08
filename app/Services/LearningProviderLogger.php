<?php

namespace App\Services;

use App\Models\LearningProvider;
use App\Models\Log;


class LearningProviderLogger
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * Index method to log viewing all learning providers.
     */
    public function index(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_LEARNING_PROVIDERS,
            [
                'Viewed all learning providers',
            ],
            $userId,
        );
    }

    /**
     * Log showing a specific learning provider.
     */
    public function show(LearningProvider $learningProvider, int $userId): array
    {
        return $this->log(
            Log::ACTION_SHOW_LEARNING_PROVIDER,
            [
                'id' => $learningProvider->id,
                'name' => $learningProvider->name,
                'slug' => $learningProvider->slug,
            ],
            $userId,
        );
    }

    /**
     * Log creating a new learning provider.
     */
    public function create(LearningProvider $learningProvider, int $userId): array
    {
        return $this->log(
            Log::ACTION_CREATE_LEARNING_PROVIDER,
            [
                'id' => $learningProvider->id,
                'name' => $learningProvider->name,
                'slug' => $learningProvider->slug,
                'created_by' => $learningProvider->created_by,
                'created_at' => $learningProvider->created_at,
            ],
            $userId,
        );
    }

    /**
     * Log updating an existing learning provider.
     */
    public function update(LearningProvider $learningProvider, int $userId): array
    {
        return $this->log(
            Log::ACTION_UPDATE_LEARNING_PROVIDER,
            [
                'id' => $learningProvider->id,
                'name' => $learningProvider->name,
                'slug' => $learningProvider->slug,
                'updated_by' => $learningProvider->updated_by,
                'updated_at' => $learningProvider->updated_at,
            ],
            $userId,
        );
    }

    /**
     * Log deleting a learning provider.
     */
    public function delete(LearningProvider $learningProvider, int $userId): array
    {
        return $this->log(
            Log::ACTION_DELETE_LEARNING_PROVIDER,
            [
                'id' => $learningProvider->id,
                'name' => $learningProvider->name,
                'slug' => $learningProvider->slug,
                'deleted_by' => $learningProvider->deleted_by,
                'deleted_at' => $learningProvider->deleted_at,
            ],
            $userId,
        );
    }

    /**
     * Log restoring a learning provider.
     */
    public function restore(LearningProvider $learningProvider, int $userId): array
    {
        return $this->log(
            Log::ACTION_REINSTATE_LEARNING_PROVIDER,
            [
                'id' => $learningProvider->id,
                'name' => $learningProvider->name,
                'slug' => $learningProvider->slug,
                'is_archived' => $learningProvider->is_archived,
                'restored_by' => $learningProvider->restored_by,
                'restored_at' => $learningProvider->restored_at,
            ],
            $userId,
        );
    }

    /**
     * Log viewing archived learning providers.
     */
    public function archived(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_ARCHIVED_LEARNING_PROVIDERS,
            [
                'Viewed archived learning providers',
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
