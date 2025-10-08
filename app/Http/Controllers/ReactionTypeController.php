<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReactionTypeRequest;
use App\Http\Requests\UpdateReactionTypeRequest;
use App\Http\Resources\ReactionTypeResource;
use App\Models\ReactionType;

class ReactionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', ReactionType::class);
        $reactionTypes = ReactionType::all();
        $json_reactionTypes = ReactionTypeResource::collection($reactionTypes);

        return $this->success($json_reactionTypes);
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
    public function store(StoreReactionTypeRequest $request)
    {
        $this->authorize('create', ReactionType::class);
        $data = $request->validated();
        $added = ReactionType::create($data);

        return $added ? $this->success() : $this->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(ReactionType $reactionType)
    {
        $this->authorize('view', $reactionType);

        $reactionType = ReactionType::with('reactions')->find($reactionType->id);
        $reactionType_json = ReactionTypeResource::make($reactionType);

        return $this->success($reactionType_json);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReactionType $reactionType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReactionTypeRequest $request, ReactionType $reactionType)
    {
        $this->authorize('update', $reactionType);
        $new_data = $request->validated();
        $updated = $reactionType->update($new_data);

        return $updated ? $this->success() : $this->fail();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReactionType $reactionType)
    {
        $this->authorize('delete', $reactionType);
        $deleted = $reactionType->delete();

        return $deleted ? $this->success() : $this->fail();
    }

    /**
     * Return a list of soft-deleted reaction types.
     */
    public function deleted()
    {
        $this->authorize('viewAny', ReactionType::class);
        $deleted_reaction_types = ReactionType::query()->onlyTrashed()->get();
        $json_reaction_types = ReactionTypeResource::collection($deleted_reaction_types);

        return $this->success($json_reaction_types);
    }

    /**
     * Restore the specified soft-deleted comment to its original state.
     *
     * @param  int  $id  The id of the comment to be restored.
     * @return string 'Success' if the comment was successfully restored, 'Failure' otherwise.
     */
    public function restore($id)
    {
        $this->authorize('restore', ReactionType::class);
        $restored = ReactionType::query()->onlyTrashed()->where('id', $id)->restore();

        return $restored ? $this->success() : $this->fail();
    }

    /**
     * Permanently delete the specified reaction type.
     *
     * @param  int  $id  The id of the reaction type to be permanently deleted.
     * @return string 'Success' if the reaction type was successfully permanently deleted, 'Failure' otherwise.
     */
    public function force_delete($id)
    {
        $this->authorize('forceDelete', ReactionType::class);
        $force_deleted = ReactionType::query()->onlyTrashed()->where('id', $id)->forceDelete();

        return $force_deleted ? $this->success() : $this->fail();
    }
}
