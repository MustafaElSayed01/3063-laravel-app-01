<?php

namespace App\Policies;

use App\Models\PostStatus;
use App\Models\User;

class PostStatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAbility('post_statuses:viewAny', ['admin', 'manager', 'user']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PostStatus $postStatus): bool
    {
        return $user->hasAbility('post_statuses:view', ['admin', 'manager'])
            || ($user->hasAbility('post_statuses:view', ['user']) && $user->id === $postStatus->user_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAbility('post_statuses:create', ['admin', 'manager', 'user']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostStatus $postStatus): bool
    {
        return $user->hasAbility('post_statuses:update', ['admin', 'manager'])
            || ($user->hasAbility('post_statuses:update', ['user']) && $user->id === $postStatus->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostStatus $postStatus): bool
    {
        return $user->hasAbility('post_statuses:delete', ['admin', 'manager'])
            || ($user->hasAbility('post_statuses:delete', ['user']) && $user->id === $postStatus->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PostStatus $postStatus): bool
    {
        return $user->hasAbility('post_statuses:restore', ['admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PostStatus $postStatus): bool
    {
        return $user->hasAbility('post_statuses:forceDelete', ['admin']);
    }
}
