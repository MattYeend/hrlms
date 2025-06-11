<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserJob;

class UserJobPolicy
{
    /**
     * Determine whether the user can view any user job models.
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
     * Determine whether the user can view a specific user job.
     *
     * @param User $user The currently authenticated user.
     * @param UserJob $userJob The user job being viewed.
     *
     * @return bool
     */
    public function view(User $user, UserJob $userJob): bool
    {
        unset($user, $userJob);
        return true;
    }

    /**
     * Determine whether the user can create a user job.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can update a user job.
     *
     * @param User $user The currently authenticated user.
     * @param UserJob $userJob The user job being updated.
     *
     * @return bool
     */
    public function update(User $user, UserJob $userJob): bool
    {
        unset($userJob);
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can delete a user job.
     *
     * @param User $user The currently authenticated user.
     * @param UserJob $userJob The user job being deleted.
     *
     * @return bool
     */
    public function delete(User $user, UserJob $userJob): bool
    {
        unset($userJob);
        return $this->isPrivileged($user);
    }

    /**
     * Determine whether the user can restore a deleted user job.
     *
     * @param User $user The currently authenticated user.
     * @param UserJob $userJob The user job being restored.
     *
     * @return bool
     */
    public function restore(User $user, UserJob $userJob): bool
    {
        unset($userJob);
        return $this->isPrivileged($user);
    }

    /**
     * Determine whether the user can permanently delete a user job.
     *
     * @param User $user The currently authenticated user.
     * @param UserJob $userJob The user job being permanently deleted.
     *
     * @return bool
     */
    public function forceDelete(User $user, UserJob $userJob): bool
    {
        unset($userJob);
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can view archived user jobs.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function viewArchived(User $user): bool
    {
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Check if the user has the 'super-admin' role.
     *
     * @param User $user The user being checked.
     *
     * @return bool
     */
    private function isSuperAdmin(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Check if the user has a privileged role (admin or high-level staff).
     *
     * @param User $user The user being checked.
     *
     * @return bool
     */
    private function isPrivileged(User $user): bool
    {
        return $user->isAtleastAdmin() || $user->isHighLevelStaff();
    }
}
