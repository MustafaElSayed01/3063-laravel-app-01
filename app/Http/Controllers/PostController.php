<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->get();
        $json_posts = PostResource::collection($posts);
        return $json_posts;
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
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $added = Post::create($data);
        return $added ? 'Success' : 'Failure';
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $exists = Post::query()->where('id', $post->id)->exists();
        if (!$exists) {
            return 'Failure: Post not found';
        }
        $post = Post::with('user')->find($post->id);
        $post_json = PostResource::make($post);
        return $post_json;
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
        $new_data = $request->validated();
        $updated = $post->update($new_data);
        return $updated ? 'Success' : 'Failure';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $exists = Post::query()->where('id', $post->id)->exists();
        if (!$exists) {
            return 'Failure: Post not found';
        }
        $deleted = $post->delete();
        return $deleted ? 'Success' : 'Failure';
    }

    /**
     * Randomly select n posts from the database.
     */
    public function random()
    {
        $posts = Post::query()->inRandomOrder()->take(5)->get();
        $json_posts = PostResource::collection($posts);
        return $json_posts;
    }

    /**
     * Return a list of soft-deleted posts.
     */
    public function deleted()
    {
        $deleted_posts = Post::query()->onlyTrashed()->get();
        $json_posts = PostResource::collection($deleted_posts);
        return $json_posts;
    }

    /**
     * Restore the specified soft-deleted post to its original state.
     *
     * @param int $id The id of the post to be restored.
     * @return string 'Success' if the post was successfully restored, 'Failure' otherwise.
     */
    public function restore($id)
    {
        $exists = Post::onlyTrashed()->where('id', $id)->exists();
        if (!$exists) {
            return 'Failure: Post not deleted';
        }
        $restored = Post::onlyTrashed()->where('id', $id)->restore();
        return $restored ? 'Success' : 'Failure';
    }

    /**
     * Permanently delete the specified post.
     *
     * @param int $id The id of the post to be permanently deleted.
     * @return string 'Success' if the post was successfully permanently deleted, 'Failure' otherwise.
     */
    public function hard_delete($id)
    {
        $exists = Post::onlyTrashed()->where('id', $id)->exists();
        if (!$exists) {
            return 'Failure: Post not deleted';
        }
        $hard_deleted = Post::onlyTrashed()->where('id', $id)->forceDelete();
        return $hard_deleted ? 'Success' : 'Failure';
    }
}