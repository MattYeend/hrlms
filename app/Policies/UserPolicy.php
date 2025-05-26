<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any users (e.g., index).
     */
    public function viewAny(User $user): bool
    {
        unset($user);
        return true;
    }

    /**
     * Determine whether the user can view a specific user.
     */
    public function view(User $user, User $target): bool
    {
        unset($user);
        unset($target);
        return true;
    }

    /**
     * Determine whether the user can create users.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update a user.
     */
    public function update(User $user, User $target): bool
    {
        return $user->id === $target->id;
    }

    /**
     * Determine whether the user can delete a user.
     */
    public function delete(User $user, User $target): bool
    {
        unset($target);
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore a soft-deleted user.
     */
    public function restore(User $user, User $target): bool
    {
        unset($target);
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete a user.
     */
    public function forceDelete(User $user, User $target): bool
    {
        unset($target);
        return $user->isAdmin() || $user->isSuperAdmin();
    }
}
