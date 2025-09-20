<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with('user')->get();
        $json_comments = CommentResource::collection($comments);
        return $json_comments;
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
        $exists = Comment::query()->where('id', $comment->id)->exists();
        if (!$exists) {
            return 'Failure: Comment not found';
        }
        $comment = Comment::with('user')->find($comment->id);
        $comment_json = CommentResource::make($comment);
        return $comment_json;
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
        $new_data = $request->validated();
        $updated = $comment->update($new_data);
        return $updated ? 'Success' : 'Failure';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $exists = Comment::query()->where('id', $comment->id)->exists();
        if (!$exists) {
            return 'Failure: Comment not found';
        }
        $deleted = $comment->delete();
        return $deleted ? 'Success' : 'Failure';
    }
    /**
     * Return a list of soft-deleted comments.
     */
    public function deleted()
    {
        $deleted_comments = Comment::query()->onlyTrashed()->get();
        $json_comments = CommentResource::collection($deleted_comments);
        return $json_comments;
    }

    /**
     * Restore the specified soft-deleted comment to its original state.
     *
     * @param int $id The id of the comment to be restored.
     * @return string 'Success' if the comment was successfully restored, 'Failure' otherwise.
     */
    public function restore($id)
    {
        $exists = Comment::onlyTrashed()->where('id', $id)->exists();
        if (!$exists) {
            return 'Failure: Comment not deleted';
        }
        $restored = Comment::onlyTrashed()->where('id', $id)->restore();
        return $restored ? 'Success' : 'Failure';
    }

    /**
     * Permanently delete the specified comment.
     *
     * @param int $id The id of the comment to be permanently deleted.
     * @return string 'Success' if the comment was successfully permanently deleted, 'Failure' otherwise.
     */
    public function hard_delete($id)
    {
        $exists = Comment::onlyTrashed()->where('id', $id)->exists();
        if (!$exists) {
            return 'Failure: Comment not deleted';
        }
        $hard_deleted = Comment::onlyTrashed()->where('id', $id)->forceDelete();
        return $hard_deleted ? 'Success' : 'Failure';
    }
}