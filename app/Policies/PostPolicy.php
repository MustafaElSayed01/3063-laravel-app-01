<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAbility('posts:viewAny', ['admin', 'manager', 'user']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return $user->hasAbility('posts:view', ['admin', 'manager'])
            || ($user->hasAbility('posts:view', ['user']) && $user->id === $post->user_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAbility('posts:create', ['admin', 'manager', 'user']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->hasAbility('posts:update', ['admin', 'manager'])
            || ($user->hasAbility('posts:update', ['user']) && $user->id === $post->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->hasAbility('posts:delete', ['admin', 'manager'])
            || ($user->hasAbility('posts:delete', ['user']) && $user->id === $post->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return $user->hasAbility('posts:restore', ['admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return $user->hasAbility('posts:forceDelete', ['admin']);
    }
}
