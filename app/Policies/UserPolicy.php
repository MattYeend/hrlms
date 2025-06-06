<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        unset($user);
        return true;
    }

    public function view(User $user, User $target): bool
    {
        unset($user, $target);
        return true;
    }

    public function create(User $user): bool
    {
        return $this->hasPrivilegedRole($user);
    }

    public function update(User $user, User $target): bool
    {
        return $this->isSelf($user, $target) ||
                $this->hasPrivilegedRole($user);
    }

    public function delete(User $user, User $target): bool
    {
        unset($target);
        return $this->hasPrivilegedRole($user);
    }

    public function restore(User $user, User $target): bool
    {
        unset($target);
        return $this->hasPrivilegedRole($user);
    }

    public function forceDelete(User $user, User $target): bool
    {
        unset($target);
        return $this->hasPrivilegedRole($user);
    }

    /**
     * Determine whether the user can view archived users.
     */
    public function viewArchived(User $user): bool
    {
        return $this->hasPrivilegedRole($user);
    }

    private function hasPrivilegedRole(User $user): bool
    {
        return $user->isAtleastAdmin() ||
               $user->isHighLevelStaff();
    }

    private function isSelf(User $user, User $target): bool
    {
        return $user->id === $target->id;
    }
}
