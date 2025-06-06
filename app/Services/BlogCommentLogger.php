<?php

namespace App\Services;

use App\Models\BlogComment;
use App\Models\Log;

class BlogCommentLogger
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * Log creating a new blogComment.
     */
    public function create(BlogComment $blogComment, int $userId): array
    {
        return $this->log(
            Log::ACTION_COMMENTED_ON_BLOG,
            [
                'id' => $blogComment->id,
                'blog_id' => $blogComment->blog_id,
                'user_id' => $blogComment->user_id,
                'comment' => $blogComment->comment,
                'created_by' => $blogComment->created_by,
                'created_at' => $blogComment->created_at,
            ],
            $userId,
        );
    }

    /**
     * Log updating an existing blogComment.
     */
    public function update(BlogComment $blogComment, int $userId): array
    {
        return $this->log(
            Log::ACTION_UPDATE_COMMENT_ON_BLOG,
            [
                'id' => $blogComment->id,
                'blog_id' => $blogComment->blog_id,
                'user_id' => $blogComment->user_id,
                'comment' => $blogComment->comment,
                'updated_by' => $blogComment->updated_by,
                'updated_at' => $blogComment->updated_at,
            ],
            $userId,
        );
    }

    /**
     * Log deleting a blogComment.
     */
    public function delete(BlogComment $blogComment, int $userId): array
    {
        return $this->log(
            Log::ACTION_UNCOMMENTED_ON_BLOG,
            [
                'id' => $blogComment->id,
                'blog_id' => $blogComment->blog_id,
                'user_id' => $blogComment->user_id,
                'comment' => $blogComment->comment,
                'deleted_by' => $blogComment->deleted_by,
                'deleted_at' => $blogComment->deleted_at,
            ],
            $userId,
        );
    }

    /**
     * Log restoring a blogComment.
     */
    public function restore(BlogComment $blogComment, int $userId): array
    {
        return $this->log(
            Log::ACTION_REINSTATE_COMMENT_ON_BLOG,
            [
                'id' => $blogComment->id,
                'blog_id' => $blogComment->blog_id,
                'user_id' => $blogComment->user_id,
                'comment' => $blogComment->comment,
                'is_archived' => $blogComment->is_archived,
                'restored_by' => $blogComment->restored_by,
                'restored_at' => $blogComment->restored_at,
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
