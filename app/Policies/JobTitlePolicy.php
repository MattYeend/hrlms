<?php

namespace App\Policies;

use App\Models\JobTitle;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobTitlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->name === 'Admin' || $user->role->name === 'Super Admin' || $user->role->name === 'Department Lead';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, JobTitle $jobTitle): bool
    {
        return $user->role->name === 'Admin' || $user->role->name === 'Super Admin';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->name === 'Admin' || $user->role->name === 'Super Admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, JobTitle $jobTitle): bool
    {
        return $user->role->name === 'Admin' || $user->role->name === 'Super Admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, JobTitle $jobTitle): bool
    {
        return $user->role->name === 'Admin' || $user->role->name === 'Super Admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, JobTitle $jobTitle): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, JobTitle $jobTitle): bool
    {
        return false;
    }
}
