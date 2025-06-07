<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        unset($user);
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Blog $blog): bool
    {
        unset($user, $blog);
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        unset($user);
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Blog $blog): bool
    {
        if ($this->isPrivileged($user)) {
            return true;
        }

        // Only allow update if blog is not approved and user owns it
        return $blog->approved === 0 && $user->id === $blog->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Blog $blog): bool
    {
        return $this->canManage($user, $blog);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Blog $blog): bool
    {
        return $this->canManage($user, $blog);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Blog $blog): bool
    {
        return $this->canManage($user, $blog);
    }

    /**
     * Determine whether the user can view the archived model.
     */
    public function viewArchived(User $user): bool
    {
        return $this->isPrivileged($user);
    }

    /**
     * Determine whether the user can view the denied model
     */
    public function viewDenied(User $user): bool
    {
        return $this->isPrivileged($user);
    }

    /**
     * Determine whether the user can approve model.
     */
    public function approve(User $user, Blog $blog)
    {
        unset($blog);
        return $this->isPrivileged($user);
    }

    private function canManage(User $user, Blog $blog): bool
    {
        if ($this->isPrivileged($user)) {
            return true;
        }

        return $user->id === $blog->user_id;
    }

    private function isPrivileged(User $user): bool
    {
        return $user->isAtleastAdmin() ||
           $user->isHighLevelStaff();
    }
}
