<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAbility('users:viewAny', ['admin', 'manager']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasAbility('users:view', ['admin', 'manager'])
            || ($user->hasAbility('users:view', ['user']) && $user->id === $model->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAbility('users:create', ['admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->hasAbility('users:update', ['admin'])
            || ($user->hasAbility('users:update', ['manager']) && $model->role !== 'admin')
            || ($user->hasAbility('users:update', ['user']) && $user->id === $model->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasAbility('users:delete', ['admin'])
            || ($user->hasAbility('users:delete', ['user']) && $user->id === $model->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasAbility('users:restore', ['admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasAbility('users:forceDelete', ['admin']);
    }

    /**
     * Determine whether the user can activate the model.
     */
    public function active(User $user): bool
    {
        return $user->hasAbility('users:active', ['admin', 'manager']);
    }

    /**
     * Determine whether the user can de-activate the model.
     */
    public function deactive(User $user): bool
    {
        return $user->hasAbility('users:deactive', ['admin', 'manager']);
    }
}
