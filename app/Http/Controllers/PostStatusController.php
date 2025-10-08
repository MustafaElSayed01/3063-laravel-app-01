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
        $this->authorize('viewAny', PostStatus::class);
        $post_statuses = PostStatus::all();
        $json_post_statuses = PostStatusResource::collection($post_statuses);

        return $this->success($json_post_statuses);
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
        $this->authorize('create', Post::class);
        $data = $request->validated();
        $added = PostStatus::create($data);

        return $added ? $this->success() : $this->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(PostStatus $postStatus)
    {
        $this->authorize('view', $postStatus);
        $post_status_json = PostStatusResource::make($postStatus);

        return $this->success($post_status_json);
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
        $this->authorize('update', $postStatus);
        $new_data = $request->validated();
        $updated = $postStatus->update($new_data);

        return $updated ? $this->success() : $this->fail();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostStatus $postStatus)
    {
        $this->authorize('delete', $postStatus);
        $post = Post::query()->where('post_status_id', $postStatus->id)->exists();
        if ($post) {
            return $this->fail();
        }
        $deleted = $postStatus->delete();

        return $deleted ? $this->success() : $this->fail();
    }

    /**
     * Return a list of soft-deleted PostStatuses.
     */
    public function deleted()
    {
        $this->authorize('viewAny', PostStatus::class);
        $deleted_post_statuses = PostStatus::query()->onlyTrashed()->get();
        $json_post_statuses = PostStatusResource::collection($deleted_post_statuses);

        return $this->success($json_post_statuses);
    }

    /**
     * Restore the specified soft-deleted Post Status to its original state.
     *
     * @param  int  $id  The id of the Post Status to be restored.
     * @return string 'Success' if the Post Status was successfully restored, 'Failure' otherwise.
     */
    public function restore($id)
    {
        $this->authorize('restore', Post::class);
        $restored = PostStatus::query()->onlyTrashed()->where('id', $id)->restore();

        return $restored ? $this->success() : $this->fail();
    }

    /**
     * Permanently delete the specified Post Status.
     *
     * @param  int  $id  The id of the Post Status to be permanently deleted.
     * @return string 'Success' if the Post Status was successfully permanently deleted, 'Failure' otherwise.
     */
    public function force_delete($id)
    {
        $this->authorize('forceDelete', PostStatus::class);
        $this->authorize('forceDelete', Post::class);
        if (Post::query()->where('post_status_id', $id)->exists()) {
            return $this->fail();
        }
        $force_deleted = PostStatus::query()->onlyTrashed()->where('id', $id)->forceDelete();

        return $force_deleted ? $this->success() : $this->fail();
    }
}
