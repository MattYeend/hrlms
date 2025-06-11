<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy
{
    /**
     * Determine whether the user can view any role models.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can view a specific role.
     *
     * @param User $user The currently authenticated user.
     * @param Role $role The role being viewed.
     *
     * @return bool
     */
    public function view(User $user, Role $role): bool
    {
        unset($role);
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can create a role.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        unset($user);
        return false;
    }

    /**
     * Determine whether the user can update a role.
     *
     * @param User $user The currently authenticated user.
     * @param Role $role The role being updated.
     *
     * @return bool
     */
    public function update(User $user, Role $role): bool
    {
        unset($user, $role);
        return false;
    }

    /**
     * Determine whether the user can delete a role.
     *
     * @param User $user The currently authenticated user.
     * @param Role $role The role being deleted.
     *
     * @return bool
     */
    public function delete(User $user, Role $role): bool
    {
        unset($user, $role);
        return false;
    }

    /**
     * Determine whether the user can restore a deleted role.
     *
     * @param User $user The currently authenticated user.
     * @param Role $role The role being restored.
     *
     * @return bool
     */
    public function restore(User $user, Role $role): bool
    {
        unset($user, $role);
        return false;
    }

    /**
     * Determine whether the user can permanently delete a role.
     *
     * @param User $user The currently authenticated user.
     * @param Role $role The role being permanently deleted.
     *
     * @return bool
     */
    public function forceDelete(User $user, Role $role): bool
    {
        unset($user, $role);
        return false;
    }
}
