<?php

namespace App\Policies;

use App\Models\LearningProvider;
use App\Models\User;

class LearningProviderPolicy
{
    /**
     * Determine whether the user can view any learning provider models.
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
     * Determine whether the user can view a specific learning provider.
     *
     * @param User $user The currently authenticated user.
     * @param LearningProvider $learningProvider The learning provider
     * being viewed.
     *
     * @return bool
     */
    public function view(User $user, LearningProvider $learningProvider): bool
    {
        unset($user, $learningProvider);
        return true;
    }

    /**
     * Determine whether the user can create a learning provider.
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
     * Determine whether the user can update a learning provider.
     *
     * @param User $user The currently authenticated user.
     * @param LearningProvider $learningProvider The learning provider
     * being updated.
     *
     * @return bool
     */
    public function update(User $user, LearningProvider $learningProvider): bool
    {
        unset($learningProvider);
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can delete a learning provider.
     *
     * @param User $user The currently authenticated user.
     * @param LearningProvider $learningProvider The learning provider
     * being deleted.
     *
     * @return bool
     */
    public function delete(User $user, LearningProvider $learningProvider): bool
    {
        unset($learningProvider);
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can restore a deleted learning provider.
     *
     * @param User $user The currently authenticated user.
     * @param LearningProvider $learningProvider The learning provider
     * being restored.
     *
     * @return bool
     */
    public function restore(
        User $user,
        LearningProvider $learningProvider
    ): bool {
        unset($learningProvider);
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can permanently delete a learning provider.
     *
     * @param User $user The currently authenticated user.
     * @param LearningProvider $learningProvider The learning provider
     * being permanently deleted.
     *
     * @return bool
     */
    public function forceDelete(
        User $user,
        LearningProvider $learningProvider
    ): bool {
        unset($user, $learningProvider);
        return false;
    }

    /**
     * Determine whether the user can view archived learning providers.
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
