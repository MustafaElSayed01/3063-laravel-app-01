<?php

namespace App\Policies;

use App\Models\ReactionType;
use App\Models\User;

class ReactionTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAbility('reaction_types:viewAny', ['admin', 'manager', 'user']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ReactionType $reactionType): bool
    {
        return $user->hasAbility('reaction_types:view', ['admin', 'manager'])
            || ($user->hasAbility('reaction_types:view', ['user']) && $user->id === $reactionType->user_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAbility('reaction_types:create', ['admin', 'manager', 'user']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ReactionType $reactionType): bool
    {
        return $user->hasAbility('reaction_types:update', ['admin', 'manager'])
            || ($user->hasAbility('reaction_types:update', ['user']) && $user->id === $reactionType->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ReactionType $reactionType): bool
    {
        return $user->hasAbility('reaction_types:delete', ['admin', 'manager'])
            || ($user->hasAbility('reaction_types:delete', ['user']) && $user->id === $reactionType->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ReactionType $reactionType): bool
    {
        return $user->hasAbility('reaction_types:restore', ['admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ReactionType $reactionType): bool
    {
        return $user->hasAbility('reaction_types:forceDelete', ['admin']);
    }
}
