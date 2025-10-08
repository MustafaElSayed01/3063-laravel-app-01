<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Post::class);
        $posts = Post::all();
        $json_posts = PostResource::collection($posts);

        return $this->success($json_posts);
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
    public function store(StorePostRequest $request)
    {
        $this->authorize('create', Post::class);
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $added = Post::create($data);

        return $added ? $this->success() : $this->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        $post->load(['post_status', 'user', 'comments', 'replies', 'reactions']);
        $post_json = PostResource::make($post);

        return $this->success($post_json);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validated();
        $updated = $post->update($data);

        return $updated ? $this->success() : $this->fail();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $deleted = $post->delete();

        return $deleted ? $this->success() : $this->fail();
    }

    /**
     * Return a list of soft-deleted posts.
     */
    public function deleted()
    {
        $this->authorize('viewAny', Post::class);
        $deleted_posts = Post::query()->onlyTrashed()->get();
        $json_posts = PostResource::collection($deleted_posts);

        return $this->success($json_posts);
    }

    /**
     * Restore the specified soft-deleted post to its original state.
     *
     * @param  int  $id  The id of the post to be restored.
     * @return string 'Success' if the post was successfully restored, 'Failure' otherwise.
     */
    public function restore($id)
    {
        $this->authorize('restore', Post::class);
        $restored = Post::query()->onlyTrashed()->where('id', $id)->restore();

        return $restored ? $this->success() : $this->fail();
    }

    /**
     * Permanently delete the specified post.
     *
     * @param  int  $id  The id of the post to be permanently deleted.
     * @return string 'Success' if the post was successfully permanently deleted, 'Failure' otherwise.
     */
    public function force_delete($id)
    {
        $this->authorize('forceDelete', Post::class);
        $force_deleted = Post::query()->onlyTrashed()->where('id', $id)->forceDelete();

        return $force_deleted ? $this->success() : $this->fail();
    }
}
