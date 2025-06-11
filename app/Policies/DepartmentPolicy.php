<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;

class DepartmentPolicy
{
    /**
     * Determine whether the user can view any department models.
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
     * Determine whether the user can view a specific department.
     *
     * @param User $user The currently authenticated user.
     * @param Department $department The department being viewed.
     *
     * @return bool
     */
    public function view(User $user, Department $department): bool
    {
        unset($user, $department);
        return true;
    }

    /**
     * Determine whether the user can create departments.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can update a department.
     *
     * @param User $user The currently authenticated user.
     * @param Department $department The department being updated.
     *
     * @return bool
     */
    public function update(User $user, Department $department): bool
    {
        unset($department);
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can delete a department.
     *
     * @param User $user The currently authenticated user.
     * @param Department $department The department being deleted.
     *
     * @return bool
     */
    public function delete(User $user, Department $department): bool
    {
        unset($department);
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can restore a deleted department.
     *
     * @param User $user The currently authenticated user.
     * @param Department $department The department being restored.
     *
     * @return bool
     */
    public function restore(User $user, Department $department): bool
    {
        unset($department);
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can permanently delete a department.
     *
     * @param User $user The currently authenticated user.
     * @param Department $department The department being permanently deleted.
     *
     * @return bool
     */
    public function forceDelete(User $user, Department $department): bool
    {
        unset($user, $department);
        return false;
    }

    /**
     * Determine whether the user can view archived departments.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function viewArchived(User $user): bool
    {
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }
}
