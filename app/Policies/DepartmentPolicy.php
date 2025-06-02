<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;

class DepartmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        unset($user, $department);
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Department $department): bool
    {
        unset($user, $department);
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Department $department): bool
    {
        unset($department);
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Department $department): bool
    {
        unset($department);
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Department $department): bool
    {
        unset($department);
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Department $department): bool
    {
        unset($user, $department);
        return false;
    }

    /**
     * Determine whether the user can view archived departments.
     */
    public function viewArchived(User $user): bool
    {
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }
}
