<?php

namespace App\Policies;

use App\Models\BlogComment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BlogCommentPolicy
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
    public function view(User $user, BlogComment $blogComment): bool
    {
        unset($user, $blogComment);
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
    public function update(User $user, BlogComment $blogComment): bool
    {

        return $user->id === $blogComment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BlogComment $blogComment): bool
    {
        return $user->id === $blogComment->user_id ||
                $this->isAdminOrSuperAdmin($user) ||
                $this->isCSuiteOrHrStaff($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BlogComment $blogComment): bool
    {
        return $user->id === $blogComment->user_id ||
                $this->isAdminOrSuperAdmin($user) ||
                $this->isCSuiteOrHrStaff($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BlogComment $blogComment): bool
    {
        return $user->id === $blogComment->user_id ||
                $this->isAdminOrSuperAdmin($user) ||
                $this->isCSuiteOrHrStaff($user);
    }

    /**
     * Determine whether the user can view archived users.
     */
    public function viewArchived(User $user): bool
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
