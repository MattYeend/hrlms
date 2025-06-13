<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogPolicy
{
    /**
     * Determine whether the user can view any blog models.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        unset($user);
        return true;
    }

    /**
     * Determine whether the user can view a specific blog.
     *
     * @param User $user The currently authenticated user.
     * @param Blog $blog The blog being viewed.
     *
     * @return bool
     */
    public function view(User $user, Blog $blog): bool
    {
        unset($user, $blog);
        return true;
    }

    /**
     * Determine whether the user can create a blog.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        unset($user);
        return true;
    }

    /**
     * Determine whether the user can update a blog.
     *
     * @param User $user The currently authenticated user.
     * @param Blog $blog The blog being updated.
     *
     * @return bool
     */
    public function update(User $user, Blog $blog): bool
    {
        if ($this->isPrivileged($user)) {
            return true;
        }

        // Only allow update if blog is not approved and user owns it
        return $blog->approved === false && $user->id === $blog->created_by;
    }

    /**
     * Determine whether the user can delete a blog.
     *
     * @param User $user The currently authenticated user.
     * @param Blog $blog The blog being deleted.
     *
     * @return bool
     */
    public function delete(User $user, Blog $blog): bool
    {
        return $this->canManage($user, $blog);
    }

    /**
     * Determine whether the user can restore a deleted blog.
     *
     * @param User $user The currently authenticated user.
     * @param Blog $blog The blog being restored.
     *
     * @return bool
     */
    public function restore(User $user, Blog $blog): bool
    {
        return $this->canManage($user, $blog);
    }

    /**
     * Determine whether the user can permanently delete a blog.
     *
     * @param User $user The currently authenticated user.
     * @param Blog $blog The blog being permanently deleted.
     *
     * @return bool
     */
    public function forceDelete(User $user, Blog $blog): bool
    {
        return $this->canManage($user, $blog);
    }

    /**
     * Determine whether the user can view archived blogs.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function viewArchived(User $user): bool
    {
        return $this->isPrivileged($user);
    }

    /**
     * Determine whether the user can view denied blos.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function viewDenied(User $user): bool
    {
        return $this->isPrivileged($user);
    }

    /**
     * Determine whether the user can approve the current blog.
     *
     * @param User $user The currently authenticated user.
     * @param Blog $blog The blog being approved
     *
     * @return bool
     */
    public function approve(User $user, Blog $blog)
    {
        unset($blog);
        return $this->isPrivileged($user);
    }

    /**
     * Determine whether the user can manage the model
     * (delete, restore, force delete).
     *
     * A user can manage the model if they are privileged
     * (admin or high-level staff)
     * or if they are the original creator of the model.
     *
     * @param User $user The currently authenticated user.
     * @param Blog $blog The blog model instance being acted upon.
     *
     * @return bool True if the user is allowed to manage the blog.
     */
    private function canManage(User $user, Blog $blog): bool
    {
        if ($this->isPrivileged($user)) {
            return true;
        }

        return $user->id === $blog->created_by;
    }

    /**
     * Check if the user has a privileged role (e.g., admin or
     * high-level staff).
     *
     * @param User $user The user whose role is being evaluated.
     *
     * @return bool True if the user is considered privileged.
     */
    private function isPrivileged(User $user): bool
    {
        return $user->isAtleastAdmin() ||
           $user->isHighLevelStaff();
    }
}
