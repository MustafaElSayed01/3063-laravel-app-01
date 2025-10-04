<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAbility('comments:viewAny', ['admin', 'manager', 'user']);

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment): bool
    {
        return $user->hasAbility('comments:view', ['admin', 'manager'])
            || ($user->hasAbility('comments:view', ['user']) && $user->id === $comment->user_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAbility('comments:create', ['admin', 'manager', 'user']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->hasAbility('comments:update', ['admin', 'manager'])
            || ($user->hasAbility('comments:update', ['user']) && $user->id === $comment->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->hasAbility('comments:delete', ['admin', 'manager'])
                || ($user->hasAbility('comments:delete', ['user']) && $user->id === $comment->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return $user->hasAbility('comments:restore', ['admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->hasAbility('comments:forceDelete', ['admin']);
    }
}
