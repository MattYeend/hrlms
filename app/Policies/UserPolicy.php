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
        return $this->isAdminOrSuperAdmin($user) ||
            $this->isCSuiteOrHrStaff($user);
    }

    public function update(User $user, User $target): bool
    {
        return $this->isSelf($user, $target) ||
                $this->isAdminOrSuperAdmin($user) ||
                $this->isCSuiteOrHrStaff($user);
    }

    public function delete(User $user, User $target): bool
    {
        unset($target);
        return $this->isAdminOrSuperAdmin($user) ||
                $this->isCSuiteOrHrStaff($user);
    }

    public function restore(User $user, User $target): bool
    {
        unset($target);
        return $this->isAdminOrSuperAdmin($user) ||
                $this->isCSuiteOrHrStaff($user);
    }

    public function forceDelete(User $user, User $target): bool
    {
        unset($target);
        return $this->isAdminOrSuperAdmin($user);
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

    private function isSelf(User $user, User $target): bool
    {
        return $user->id === $target->id;
    }

    private function isCSuiteOrHrStaff(User $user): bool
    {
        return $user->isCSuiteStaff() || $user->isHRStaff();
    }
}
