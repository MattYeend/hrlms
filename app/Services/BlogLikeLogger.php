<?php

namespace App\Services;

use App\Models\BlogLike;
use App\Models\Log;

class BlogLikeLogger
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * Log creating a new blogLike.
     */
    public function like(BlogLike $blogLike, int $userId): array
    {
        return $this->log(
            Log::ACTION_LIKED_BLOG,
            [
                'id' => $blogLike->id,
                'blog_id' => $blogLike->blog_id,
                'user_id' => $blogLike->user_id,
                'created_by' => $blogLike->created_by,
                'created_at' => $blogLike->created_at,
            ],
            $userId,
        );
    }

    /**
     * Log updating an existing blogLike.
     */
    public function unlike(BlogLike $blogLike, int $userId): array
    {
        return $this->log(
            Log::ACTION_UNLIKED_BLOG,
            [
                'id' => $blogLike->id,
                'blog_id' => $blogLike->blog_id,
                'user_id' => $blogLike->user_id,
                'updated_by' => $blogLike->updated_by,
                'updated_at' => $blogLike->updated_at,
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