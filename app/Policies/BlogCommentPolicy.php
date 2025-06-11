<?php

namespace App\Policies;

use App\Models\BlogComment;
use App\Models\User;

class BlogCommentPolicy
{
    /**
     * Determine whether the user can view any blog comments.
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
     * Determine whether the user can view a specific blog comment.
     *
     * @param User $user The currently authenticated user.
     * @param BlogComment $blogComment The blog comment being viewed.
     *
     * @return bool
     */
    public function view(User $user, BlogComment $blogComment): bool
    {
        unset($user, $blogComment);
        return true;
    }

    /**
     * Determine whether the user can create a new blog comment.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        unset($user);
        return true;
    }

    /**
     * Determine whether the user can update a specific blog comment.
     * Only the owner of the comment may update it.
     *
     * @param User $user The currently authenticated user.
     * @param BlogComment $blogComment The blog comment being updated.
     *
     * @return bool
     */
    public function update(User $user, BlogComment $blogComment): bool
    {
        return $user->id === $blogComment->user_id;
    }

    /**
     * Determine whether the user can delete a specific blog comment.
     * Allowed if the user is the comment owner or has a privileged role.
     *
     * @param User $user The currently authenticated user.
     * @param BlogComment $blogComment The blog comment being deleted.
     *
     * @return bool
     */
    public function delete(User $user, BlogComment $blogComment): bool
    {
        return $this->canManage($user, $blogComment);
    }

    /**
     * Determine whether the user can restore a deleted blog comment.
     *
     * @param User $user The currently authenticated user.
     * @param BlogComment $blogComment The blog comment being restored.
     *
     * @return bool
     */
    public function restore(User $user, BlogComment $blogComment): bool
    {
        return $this->canManage($user, $blogComment);
    }

    /**
     * Determine whether the user can permanently delete a blog comment.
     *
     * @param User $user The currently authenticated user.
     * @param BlogComment $blogComment The blog comment being
     * permanently deleted.
     *
     * @return bool
     */
    public function forceDelete(User $user, BlogComment $blogComment): bool
    {
        return $this->canManage($user, $blogComment);
    }

    /**
     * Determine whether the user can view archived blog comments.
     *
     * @param User $user The currently authenticated user.
     *
     * @return bool
     */
    public function viewArchived(User $user): bool
    {
        return $this->hasPrivilegedRole($user);
    }

    /**
     * Helper method to determine if the user can manage the blog comment.
     * The user must either be the owner or have a privileged role.
     *
     * @param User $user The currently authenticated user.
     * @param BlogComment $blogComment The blog comment being managed.
     *
     * @return bool
     */
    private function canManage(User $user, BlogComment $blogComment): bool
    {
        return $user->id === $blogComment->user_id ||
               $this->hasPrivilegedRole($user);
    }

    /**
     * Helper method to determine if the user has a privileged role.
     * Checks if the user is a high-level staff or admin.
     *
     * @param User $user The user being evaluated.
     *
     * @return bool
     */
    private function hasPrivilegedRole(User $user): bool
    {
        return $this->isJob($user) ||
               $user->isAtleastAdmin();
    }

    /**
     * Helper method to check if the user holds a high-level staff role.
     *
     * @param User $user The user being evaluated.
     *
     * @return bool
     */
    private function isJob(User $user): bool
    {
        return $user->isHighLevelStaff();
    }
}
