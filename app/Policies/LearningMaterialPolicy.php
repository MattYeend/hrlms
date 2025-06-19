<?php

namespace App\Policies;

use App\Models\LearningMaterial;
use App\Models\User;

class LearningMaterialPolicy
{
    /**
     * Determine whether the user can view any learning material models.
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
     * Determine whether the user can view a specific learning material.
     *
     * @param User $user The currently authenticated user.
     * @param LearningMaterial $learningMaterial The learning material
     * being viewed.
     *
     * @return bool
     */
    public function view(User $user, LearningMaterial $learningMaterial): bool
    {
        unset($user, $learningMaterial);
        return true;
    }

    /**
     * Determine whether the user can create a learning material.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $this->isPrivileged($user);
    }

    /**
     * Determine whether the user can update a learning material.
     *
     * @param User $user The currently authenticated user.
     * @param LearningMaterial $learingMaterial The learning material being
     * updated.
     *
     * @return bool
     */
    public function update(User $user, LearningMaterial $learningMaterial): bool
    {
        if ($this->isPrivileged($user)) {
            return true;
        }

        $hasBeenCompleted = $learningMaterial->completedBy()->exists();
        $hasStarted = $learningMaterial->hasStarted()->exists();

        return ! $hasBeenCompleted && ! $hasStarted && $user->id ===
            $learningMaterial->created_by;
    }

    /**
     * Determine whether the user can delete a learning material.
     *
     * @param User $user The currently authenticated user.
     * @param LearningMaterial $learningMaterial The learning material
     * being deleted.
     *
     * @return bool
     */
    public function delete(User $user, LearningMaterial $learningMaterial): bool
    {
        unset($learningMaterial);
        return $this->isPrivileged($user);
    }

    /**
     * Determine whether the user can restore a deleted learning material.
     *
     * @param User $user The currently authenticated user.
     * @param LearningMaterial $learningMaterial The learning material
     * being restored.
     *
     * @return bool
     */
    public function restore(
        User $user,
        LearningMaterial $learningMaterial
    ): bool {
        unset($learningMaterial);
        return $this->isPrivileged($user);
    }

    /**
     * Determine whether the user can permanently delete a learning material.
     *
     * @param User $user The currently authenticated user.
     * @param LearningMaterial $learningMaterial The learning material
     * being permanently deleted.
     *
     * @return bool
     */
    public function forceDelete(
        User $user,
        LearningMaterial $learningMaterial
    ): bool {
        unset($user, $learningMaterial);
        return false;
    }

    /**
     * Determine whether the user can view archived learning materials.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function viewArchived(User $user): bool
    {
        return $this->isPrivileged($user);
    }

    /**
     * Determine whether the user can start the learning material.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function canStart(User $user): bool
    {
        unset($user);
        return true;
    }

    /**
     * Determine whether the user can end the learning material.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function canEnd(User $user): bool
    {
        unset($user);
        return true;
    }

    /**
     * Check if the user has a privileged role (e.g., admin or
     * high-level staff).
     *
     * @param User $user The user whose role is being evaluated.
     *
     * @return bool True if the user is considered privileged.
     */
    private function isPrivileged(User $user): bool
    {
        return $user->isAtleastAdmin() ||
           $user->isHighLevelStaff();
    }
}
