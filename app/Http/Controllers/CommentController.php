<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', arguments: Comment::class);
        $comments = Comment::all();

        return CommentResource::collection($comments);
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
    public function store(StoreCommentRequest $request)
    {
        $this->authorize('create', Comment::class);
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $added = Comment::create($data);

        return $added ? 'Success' : 'Failure';
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $this->authorize('view', $comment);

        $comment->load(['post', 'user', 'replies', 'reactions']);

        return CommentResource::make($comment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $new_data = $request->validated();
        $updated = $comment->update($new_data);

        return $updated ? 'Success' : 'Failure';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $deleted = $comment->delete();

        return $deleted ? 'Success' : 'Failure';
    }

    /**
     * Return a list of soft-deleted comments.
     */
    public function deleted()
    {
        $this->authorize('viewAny', Comment::class);
        $deleted_comments = Comment::query()->onlyTrashed()->get();
        $json_comments = CommentResource::collection($deleted_comments);

        return $json_comments;
    }

    /**
     * Restore the specified soft-deleted comment to its original state.
     *
     * @param  int  $id  The id of the comment to be restored.
     * @return string 'Success' if the comment was successfully restored, 'Failure' otherwise.
     */
    public function restore($id)
    {
        $this->authorize('restore', Comment::class);

        $restored = Comment::query()->onlyTrashed()->where('id', $id)->restore();

        return $restored ? 'Success' : 'Failure';
    }

    /**
     * Permanently delete the specified comment.
     *
     * @param  int  $id  The id of the comment to be permanently deleted.
     * @return string 'Success' if the comment was successfully permanently deleted, 'Failure' otherwise.
     */
    public function force_delete($id)
    {
        $this->authorize('forceDelete', Comment::class);

        $force_deleted = Comment::query()->onlyTrashed()->where('id', $id)->forceDelete();

        return $force_deleted ? 'Success' : 'Failure';
    }
}
