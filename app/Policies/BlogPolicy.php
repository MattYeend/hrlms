<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

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
        return ($blog->approved == 0 &&
                $user->id === $blog->user_id) ||
                $this->isAdminOrSuperAdmin($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Blog $blog): bool
    {
        return $user->id === $blog->user_id ||
                $this->isAdminOrSuperAdmin($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Blog $blog): bool
    {
        return $user->id === $blog->user_id ||
                $this->isAdminOrSuperAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Blog $blog): bool
    {
        return $user->id === $blog->user_id ||
                $this->isAdminOrSuperAdmin($user);
    }

    /**
     * Determine whether the user can view archived users.
     */
    public function viewArchived(User $user): bool
    {
        return $this->isAdminOrSuperAdmin($user) ||
                $this->isCSuiteOrHrStaff($user);
    }

    /**
     * Determine whether the user can approve blogs.
     */
    public function approve(User $user, Blog $blog)
    {
        return $this->isAdminOrSuperAdmin($user) ||
                $this->isCSuiteOrHrStaff($user);
    }

    private function isAdminOrSuperAdmin(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    private function isCSuiteOrHrStaff(User $user): bool
    {
        return $user->isCSuiteStaff() || $user->isHRStaff();
    }
}
