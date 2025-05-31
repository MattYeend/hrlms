<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        unset($user); // Unused parameter, can be removed if not needed
        return true;
    }

    public function view(User $user, User $target): bool
    {
        unset($user); // Unused parameter, can be removed if not needed
        unset($target); // Unused parameter, can be removed if not needed
        return true;
    }

    public function create(User $user): bool
    {
        return $this->isAdminOrSuperAdmin($user);
    }

    public function update(User $user, User $target): bool
    {
        return $this->isSelf($user, $target) ||
                $this->isAdminOrSuperAdmin($user);
    }

    public function delete(User $user, User $target): bool
    {
        unset($target); // Unused parameter, can be removed if not needed
        return $this->isAdminOrSuperAdmin($user);
    }

    public function restore(User $user, User $target): bool
    {
        unset($target); // Unused parameter, can be removed if not needed
        return $this->isAdminOrSuperAdmin($user);
    }

    public function forceDelete(User $user, User $target): bool
    {
        unset($target); // Unused parameter, can be removed if not needed
        return $this->isAdminOrSuperAdmin($user);
    }

    /**
     * Determine whether the user can view archived users.
     */
    public function viewArchived(User $user): bool
    {
        return $this->isAdminOrSuperAdmin($user);
    }

    private function isAdminOrSuperAdmin(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    private function isSelf(User $user, User $target): bool
    {
        return $user->id === $target->id;
    }
}
