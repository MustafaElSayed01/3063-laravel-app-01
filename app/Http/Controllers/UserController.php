<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validated();
        $user = User::create($data);

        return $user
            ? new UserResource($user)
            : response()->json(['message' => 'Failure'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->load(['posts', 'comments', 'replies']);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->validated();
        $updated = $user->update($data);

        return $updated
            ? new UserResource($user->fresh())
            : response()->json(['message' => 'Failure'], 400);
    }

    /**
     * Soft delete the specified resource.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $deleted = $user->delete();

        return $deleted
            ? response()->json(['message' => 'User soft deleted'])
            : response()->json(['message' => 'Failure'], 400);
    }

    /**
     * Return a list of soft-deleted users.
     */
    public function deleted()
    {
        $this->authorize('viewAny', User::class);

        $deletedUsers = User::onlyTrashed()->get();

        return UserResource::collection($deletedUsers);
    }

    /**
     * Restore the specified soft-deleted user.
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $user);

        $restored = $user->restore();

        return $restored
            ? response()->json(['message' => 'User restored'])
            : response()->json(['message' => 'Failure'], 400);
    }

    /**
     * Permanently delete the specified user.
     */
    public function force_delete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $user);

        $force_deleted = $user->forceDelete();

        return $force_deleted
            ? response()->json(['message' => 'User permanently deleted'])
            : response()->json(['message' => 'Failure'], 400);
    }
}
