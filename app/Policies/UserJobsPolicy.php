<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserJobs;
use Illuminate\Auth\Access\Response;

class UserJobsPolicy
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
    public function view(User $user, UserJobs $userJobs): bool
    {
        unset($user, $userJobs);
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserJobs $userJobs): bool
    {
        unset($userJobs);
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserJobs $userJobs): bool
    {
        unset($userJobs);
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserJobs $userJobs): bool
    {
        unset($userJobs);
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserJobs $userJobs): bool
    {
        unset($userJobs);
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view archived departments.
     */
    public function viewArchived(User $user): bool
    {
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }
}
