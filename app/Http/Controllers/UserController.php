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
        $users = User::all();
        $users = UserResource::collection($users);

        return $users;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $added = User::create($data);

        return $added ? 'Success' : 'Failure';
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $exists = User::query()->where('id', $user->id)->exists();
        if (! $exists) {
            return 'Failure: User not found';
        }
        $user = User::with('posts', 'comments', 'replies')->find($user->id);
        $user_json = UserResource::make($user);

        return $user_json;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $new_data = $request->validated();
        $updated = $user->update($new_data);

        return $updated ? 'Success' : 'Failure';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $exists = User::query()->where('id', $user->id)->exists();
        if (! $exists) {
            return 'Failure: User not found';
        }
        $deleted = $user->delete();

        return $deleted ? 'Success' : 'Failure';
    }

    /**
     * Return a list of soft-deleted comments.
     */
    public function deleted()
    {
        $deleted_users = User::query()->onlyTrashed()->get();
        $json_users = UserResource::collection($deleted_users);

        return $json_users;
    }

    /**
     * Restore the specified soft-deleted user to its original state.
     *
     * @param  int  $id  The id of the user to be restored.
     * @return string 'Success' if the user was successfully restored, 'Failure' otherwise.
     */
    public function restore($id)
    {
        $exists = User::query()->onlyTrashed()->where('id', $id)->exists();
        if (! $exists) {
            return 'Failure: User not deleted';
        }
        $restored = User::query()->onlyTrashed()->where('id', $id)->restore();

        return $restored ? 'Success' : 'Failure';
    }

    /**
     * Permanently delete the specified user.
     *
     * @param  int  $id  The id of the user to be permanently deleted.
     * @return string 'Success' if the user was successfully permanently deleted, 'Failure' otherwise.
     */
    public function hard_delete($id)
    {
        $exists = User::query()->onlyTrashed()->where('id', $id)->exists();
        if (! $exists) {
            return 'Failure: User not deleted';
        }
        $hard_deleted = User::query()->onlyTrashed()->where('id', $id)->forceDelete();

        return $hard_deleted ? 'Success' : 'Failure';
    }
}
