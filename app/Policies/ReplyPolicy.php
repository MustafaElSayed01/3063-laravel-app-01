<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;

class ReplyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAbility('replies:viewAny', ['admin', 'manager', 'user']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reply $reply): bool
    {
        return $user->hasAbility('replies:view', ['admin', 'manager'])
            || ($user->hasAbility('replies:view', ['user']) && $user->id === $reply->user_id);

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAbility('replies:create', ['admin', 'manager', 'user']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reply $reply): bool
    {
        return $user->hasAbility('replies:update', ['admin', 'manager'])
            || ($user->hasAbility('replies:update', ['user']) && $user->id === $reply->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reply $reply): bool
    {
        return $user->hasAbility('replies:delete', ['admin', 'manager'])
            || ($user->hasAbility('replies:delete', ['user']) && $user->id === $reply->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reply $reply): bool
    {
        return $user->hasAbility('replies:restore', ['admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reply $reply): bool
    {
        return $user->hasAbility('replies:forceDelete', ['admin']);
    }
}
