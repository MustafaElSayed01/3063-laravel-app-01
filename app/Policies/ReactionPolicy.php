<?php

namespace App\Policies;

use App\Models\Reaction;
use App\Models\User;

class ReactionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAbility('reactions:viewAny', ['admin', 'manager', 'user']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reaction $reaction): bool
    {
        return $user->hasAbility('reactions:view', ['admin', 'manager'])
            || ($user->hasAbility('reactions:view', ['user']) && $user->id === $reaction->user_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAbility('reactions:create', ['admin', 'manager', 'user']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reaction $reaction): bool
    {
        return $user->hasAbility('reactions:update', ['admin', 'manager'])
            || ($user->hasAbility('reactions:update', ['user']) && $user->id === $reaction->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reaction $reaction): bool
    {
        return $user->hasAbility('reactions:delete', ['admin', 'manager'])
            || ($user->hasAbility('reactions:delete', ['user']) && $user->id === $reaction->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reaction $reaction): bool
    {
        return $user->hasAbility('reactions:restore', ['admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reaction $reaction): bool
    {
        return $user->hasAbility('reactions:forceDelete', ['admin']);
    }
}
