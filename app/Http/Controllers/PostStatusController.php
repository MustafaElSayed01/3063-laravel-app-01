<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostStatusRequest;
use App\Http\Requests\UpdatePostStatusRequest;
use App\Http\Resources\PostStatusResource;
use App\Models\Post;
use App\Models\PostStatus;

class PostStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post_statuses = PostStatus::all();
        $json_post_statuses = PostStatusResource::collection($post_statuses);

        return $json_post_statuses;
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
    public function store(StorePostStatusRequest $request)
    {
        $data = $request->validated();
        $added = PostStatus::create($data);

        return $added ? 'Success' : 'Failure';
    }

    /**
     * Display the specified resource.
     */
    public function show(PostStatus $postStatus)
    {
        $exists = PostStatus::query()->where('id', $postStatus->id)->exists();
        if (! $exists) {
            return 'Failure: Post not found';
        }
        $post_status_json = PostStatusResource::make($postStatus);

        return $post_status_json;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostStatus $postStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostStatusRequest $request, PostStatus $postStatus)
    {
        $new_data = $request->validated();
        $updated = $postStatus->update($new_data);

        return $updated ? 'Success' : 'Failure';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostStatus $postStatus)
    {
        $exists = PostStatus::query()->where('id', $postStatus->id)->exists();
        if (! $exists) {
            return 'Failure: Post Status not found';
        }
        if (Post::query()->where('post_status_id', $postStatus->id)->exists()) {
            return 'Failure: Cannot delete status with assigned posts';
        }
        $deleted = $postStatus->delete();

        return $deleted ? 'Success' : 'Failure';
    }

    /**
     * Return a list of soft-deleted PostStatuses.
     */
    public function deleted()
    {
        $deleted_posts = PostStatus::query()->onlyTrashed()->get();
        $json_posts = PostStatusResource::collection($deleted_posts);

        return $json_posts;
    }

    /**
     * Restore the specified soft-deleted Post Status to its original state.
     *
     * @param  int  $id  The id of the Post Status to be restored.
     * @return string 'Success' if the Post Status was successfully restored, 'Failure' otherwise.
     */
    public function restore($id)
    {
        $exists = PostStatus::query()->onlyTrashed()->where('id', $id)->exists();
        if (! $exists) {
            return 'Failure: Post Status not deleted';
        }
        $restored = PostStatus::query()->onlyTrashed()->where('id', $id)->restore();

        return $restored ? 'Success' : 'Failure';
    }

    /**
     * Permanently delete the specified Post Status.
     *
     * @param  int  $id  The id of the Post Status to be permanently deleted.
     * @return string 'Success' if the Post Status was successfully permanently deleted, 'Failure' otherwise.
     */
    public function hard_delete($id)
    {
        $exists = PostStatus::query()->onlyTrashed()->where('id', $id)->exists();
        if (! $exists) {
            return 'Failure: Post Status not deleted';
        }
        if (Post::query()->where('post_status_id', $id)->exists()) {
            return 'Failure: Cannot delete status with assigned posts';
        }
        $hard_deleted = PostStatus::query()->onlyTrashed()->where('id', $id)->forceDelete();

        return $hard_deleted ? 'Success' : 'Failure';
    }
}
