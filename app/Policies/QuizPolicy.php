<?php

namespace App\Policies;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuizPolicy
{
    /**
     * Determine whether the user can view any quiz models.
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
     * Determine whether the user can view a specific quiz.
     *
     * @param User $user The currently authenticated user.
     * @param Quiz $quiz The quiz being viewed.
     *
     * @return bool
     */
    public function view(User $user, Quiz $quiz): bool
    {
        unset($user, $quiz);
        return true;
    }

    /**
     * Determine whether the user can create a quiz.
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
     * Determine whether the user can update a quiz.
     *
     * @param User $user The currently authenticated user.
     * @param Quiz $quiz The quiz being updated.
     *
     * @return bool
     */
    public function update(User $user, Quiz $quiz): bool
    {
        if ($quiz->completedBy()->exists()) {
            return false;
        }
    
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can delete a quiz.
     *
     * @param User $user The currently authenticated user.
     * @param Quiz $quiz The quiz being deleted.
     *
     * @return bool
     */
    public function delete(User $user, Quiz $quiz): bool
    {
        unset($quiz);
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can restore a deleted quiz.
     *
     * @param User $user The currently authenticated user.
     * @param Quiz $quiz The quiz being restored.
     *
     * @return bool
     */
    public function restore(User $user, Quiz $quiz): bool
    {
        unset($quiz);
        return in_array($user->role->slug, ['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can permanently delete a quiz.
     *
     * @param User $user The currently authenticated user.
     * @param Quiz $quiz The quiz being permanently deleted.
     *
     * @return bool
     */
    public function forceDelete(User $user, Quiz $quiz): bool
    {
        unset($user, $quiz);
        return false;
    }

    /**
     * Determine whether the user can view archived quizzes.
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
