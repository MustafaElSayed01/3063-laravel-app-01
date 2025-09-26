<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\UpdateReplyRequest;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $replies = Reply::all();
        $replies = ReplyResource::collection($replies);
        return $replies;
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
    public function store(StoreReplyRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $added = Reply::create($data);
        return $added ? 'Success' : 'Failure';
    }

    /**
     * Display the specified resource.
     */
    public function show(Reply $reply)
    {
        $exists = Reply::query()->where('id', $reply->id)->exists();
        if (!$exists) {
            return 'Failure: Reply not found';
        }
        $reply = Reply::with('user')->find($reply->id);
        $reply_json = ReplyResource::make($reply);
        return $reply_json;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReplyRequest $request, Reply $reply)
    {
        $new_data = $request->validated();
        $updated = $reply->update($new_data);
        return $updated ? 'Success' : 'Failure';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reply $reply)
    {
        $exists = Reply::query()->where('id', $reply->id)->exists();
        if (!$exists) {
            return 'Failure: Reply not found';
        }
        $deleted = $reply->delete();
        return $deleted ? 'Success' : 'Failure';
    }
    /**
     * Return a list of soft-deleted replies.
     */
    public function deleted()
    {
        $deleted_replies = Reply::query()->onlyTrashed()->get();
        $json_replies = ReplyResource::collection($deleted_replies);
        return $json_replies;
    }

    /**
     * Restore the specified soft-deleted reply to its original state.
     *
     * @param int $id The id of the reply to be restored.
     * @return string 'Success' if the reply was successfully restored, 'Failure' otherwise.
     */
    public function restore($id)
    {
        $exists = Reply::onlyTrashed()->where('id', $id)->exists();
        if (!$exists) {
            return 'Failure: Reply not deleted';
        }
        $restored = Reply::onlyTrashed()->where('id', $id)->restore();
        return $restored ? 'Success' : 'Failure';
    }

    /**
     * Permanently delete the specified reply.
     *
     * @param int $id The id of the reply to be permanently deleted.
     * @return string 'Success' if the reply was successfully permanently deleted, 'Failure' otherwise.
     */
    public function hard_delete($id)
    {
        $exists = Reply::onlyTrashed()->where('id', $id)->exists();
        if (!$exists) {
            return 'Failure: Reply not deleted';
        }
        $hard_deleted = Reply::onlyTrashed()->where('id', $id)->forceDelete();
        return $hard_deleted ? 'Success' : 'Failure';
    }
}