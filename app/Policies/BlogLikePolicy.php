<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogLikePolicy
{
    /**
     * Determine whether the user can like the blog.
     */
    public function like(User $user, Blog $blog): bool
    {
        // User can like only if they haven't already liked this blog
        return ! $blog->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can unlike the blog.
     */
    public function unlike(User $user, Blog $blog): bool
    {
        // User can unlike only if they already liked this blog
        return $blog->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can view likes on a blog.
     */
    public function viewLikes(User $user, Blog $blog): bool
    {
        unset($user, $blog);
        return true;
    }

    /**
     * Determine whether the user can moderate likes
     * (e.g. delete others' likes).
     */
    public function moderateLikes(User $user): bool
    {
        return $user->isAtleastAdmin();
    }
}
