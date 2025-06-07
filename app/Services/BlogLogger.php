<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Log;

class BlogLogger
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * Index method to log viewing all blogs.
     */
    public function index(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_BLOGS,
            [
                'Viewed all blogs',
            ],
            $userId,
        );
    }

    /**
     * Log showing a specific blogs.
     */
    public function show(Blog $blog, int $userId): array
    {
        return $this->log(
            Log::ACTION_SHOW_BLOG,
            [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'approved' => $blog->approved,
                'approved by' => $blog->approved_by,
                'approved_at' => $blog->approved_at,
            ],
            $userId,
        );
    }

    /**
     * Log creating a new blog.
     */
    public function create(Blog $blog, int $userId): array
    {
        return $this->log(
            Log::ACTION_CREATE_BLOG,
            [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'created_by' => $blog->created_by,
                'created_at' => $blog->created_at,
            ],
            $userId,
        );
    }

    /**
     * Log updating an existing blog.
     */
    public function update(Blog $blog, int $userId): array
    {
        return $this->log(
            Log::ACTION_UPDATE_BLOG,
            [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'updated_by' => $blog->updated_by,
                'updated_at' => $blog->updated_at,
            ],
            $userId,
        );
    }

    /**
     * Log deleting a blog.
     */
    public function delete(Blog $blog, int $userId): array
    {
        return $this->log(
            Log::ACTION_DELETE_BLOG,
            [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'deleted_by' => $blog->deleted_by,
                'deleted_at' => $blog->deleted_at,
            ],
            $userId,
        );
    }

    /**
     * Log restoring a blog.
     */
    public function restore(Blog $blog, int $userId): array
    {
        return $this->log(
            Log::ACTION_REINSTATE_BLOG,
            [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'is_archived' => $blog->is_archived,
                'restored_by' => $blog->restored_by,
                'restored_at' => $blog->restored_at,
            ],
            $userId,
        );
    }

    /**
     * Log viewing archived blogs.
     */
    public function archived(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_ARCHIVED_BLOGS,
            [
                'Viewed archived blogs',
            ],
            $userId,
        );
    }

    /**
     * Log to approve blogs
     */
    public function approved(Blog $blog, int $userId): array
    {
        return $this->log(
            Log::ACTION_APPROVE_BLOG,
            [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'approved' => $blog->approved,
                'approved_by' => $blog->approved_by,
                'approved_at' => $blog->approved_at,
                'denied' => $blog->denied,
                'denied_by' => $blog->denied_by,
                'denied_at' => $blog->denied_at,
            ],
            $userId,
        );
    }

    /**
     * Log to denied blogs
     */
    public function denied(Blog $blog, int $userId): array
    {
        return $this->log(
            Log::ACTION_DENY_BLOG,
            [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'approved' => $blog->approved,
                'approved_by' => $blog->approved_by,
                'approved_at' => $blog->approved_at,
                'denied' => $blog->denied,
                'denied_by' => $blog->denied_by,
                'denied_at' => $blog->denied_at,
            ],
            $userId,
        );
    }

    /**
     * Log for viewing denied blogs
     */
    public function viewDenied(int $userId): array
    {
        return $this->log(
            Log::ACTION_VIEW_DENIED_BLOGS,
            [
                'View denied blogs'
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
