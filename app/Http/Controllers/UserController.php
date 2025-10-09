<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Mail\VerifyMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::all();
        $json_users = UserResource::collection($users);

        return $this->success($json_users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        $data = $request->validated();
        $added = User::create($data);

        return $added ? $this->success() : $this->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        $user->load(['posts', 'comments', 'replies']);
        $user_json = UserResource::make($user);

        return $this->success($user_json);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validated();
        $updated = $user->update($data);

        return $updated ? $this->success() : $this->fail();
    }

    /**
     * Soft delete the specified resource.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $deleted = $user->delete();

        return $deleted ? $this->success() : $this->fail();
    }

    /**
     * Return a list of soft-deleted users.
     */
    public function deleted()
    {
        $this->authorize('viewAny', User::class);
        $deletedUsers = User::onlyTrashed()->get();
        $json_data = UserResource::collection($deletedUsers);

        return $this->success($json_data);
    }

    /**
     * Restore the specified soft-deleted user.
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $user);

        $restored = $user->restore();

        return $restored ? $this->success() : $this->fail();
    }

    /**
     * Permanently delete the specified user.
     */
    public function force_delete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $user);

        $force_deleted = $user->forceDelete();

        return $force_deleted ? $this->success() : $this->fail();
    }
        public function verify_email()
        {
             $user = auth()->user();
            // $this->authorize('verifyEmail', $user);
            
            Mail::to($user['email'])->send(new VerifyMail($user, $user->token));
            $user->update(['token' => null]);
            return $this->success();
        }
}
