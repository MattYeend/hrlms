<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserJob;
use Illuminate\Auth\Access\Response;

class UserJobPolicy
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
    public function view(User $user, UserJob $userJob): bool
    {
        unset($user, $userJob);
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
    public function update(User $user, UserJob $userJob): bool
    {
        unset($userJob);
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserJob $userJob): bool
    {
        unset($userJob);
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserJob $userJob): bool
    {
        unset($userJob);
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserJob $userJob): bool
    {
        unset($userJob);
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
