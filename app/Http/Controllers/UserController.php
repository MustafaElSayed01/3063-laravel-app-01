<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Mail\VerifyMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', User::class);
        $users = User::all();
        $json_users = UserResource::collection($users);

        return $this->success($json_users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);
        $data = $request->validated();
        $added = User::create($data);

        return $added ? $this->success() : $this->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        $this->authorize('view', $user);
        $user->load(['posts', 'comments', 'replies']);
        $user_json = UserResource::make($user);

        return $this->success($user_json);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);
        $data = $request->validated();

        $originalEmail = $user->email;
        $updated = $user->update($data);

        if ($updated && isset($data['email']) && $data['email'] !== $originalEmail) {
            // Reset verification state
            $user->forceFill([
                'email_verified_at' => null,
                'email_verification_token' => Str::uuid(),
            ])->save();

            // Send verification mail
            $verificationUrl = url('/api/auth/email/verify?token='.$user->email_verification_token);
            Mail::to($user->email)->send(new VerifyMail($user, $verificationUrl));
        }

        return $updated ? $this->success() : $this->fail();
    }

    /**
     * Soft delete the specified resource.
     */
    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);
        $deleted = $user->delete();

        return $deleted ? $this->success() : $this->fail();
    }

    /**
     * Return a list of soft-deleted users.
     */
    public function deleted(): JsonResponse
    {
        $this->authorize('viewAny', User::class);
        $deletedUsers = User::onlyTrashed()->get();
        $json_data = UserResource::collection($deletedUsers);

        return $this->success($json_data);
    }

    /**
     * Restore the specified soft-deleted user.
     */
    public function restore($id): JsonResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $user);
        $restored = $user->restore();

        return $restored ? $this->success() : $this->fail();
    }

    /**
     * Permanently delete the specified user.
     */
    public function force_delete($id): JsonResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $user);
        $force_deleted = $user->forceDelete();

        return $force_deleted ? $this->success() : $this->fail();
    }

    /**
     * Activate the specified user.
     */
    public function active($id): JsonResponse
    {
        $this->authorize('active', User::class);
        $user = User::findOrFail($id);
        $active = $user->update(['is_active' => true]);

        return $active ? $this->success() : $this->fail();
    }

    /**
     * Deactivate the specified user.
     */
    public function deactive($id): JsonResponse
    {
        $this->authorize('deactive', User::class);
        $user = User::findOrFail($id);
        $deactive = $user->update(['is_active' => false]);

        return $deactive ? $this->success() : $this->fail();
    }
}
