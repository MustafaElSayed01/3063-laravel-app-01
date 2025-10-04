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
        $reactionTypes = ReactionType::all();
        $json_reactionTypes = ReactionTypeResource::collection($reactionTypes);

        return $json_reactionTypes;
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
        $data = $request->validated();
        $added = ReactionType::create($data);

        return $added ? 'Success' : 'Failure';
    }

    /**
     * Display the specified resource.
     */
    public function show(ReactionType $reactionType)
    {
        $exists = ReactionType::query()->where('id', $reactionType->id)->exists();
        if (! $exists) {
            return 'Failure: Reaction Type not found';
        }
        $reactionType = ReactionType::with('reactions')->find($reactionType->id);
        $reactionType_json = ReactionTypeResource::make($reactionType);

        return $reactionType_json;
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
        $new_data = $request->validated();
        $updated = $reactionType->update($new_data);

        return $updated ? 'Success' : 'Failure';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReactionType $reactionType)
    {
        $exists = ReactionType::query()->where('id', $reactionType->id)->exists();
        if (! $exists) {
            return 'Failure: reaction type not found';
        }
        $deleted = $reactionType->delete();

        return $deleted ? 'Success' : 'Failure';
    }

    /**
     * Return a list of soft-deleted reaction types.
     */
    public function deleted()
    {
        $deleted_reaction_types = ReactionType::query()->onlyTrashed()->get();
        $json_reaction_types = ReactionTypeResource::collection($deleted_reaction_types);

        return $json_reaction_types;
    }

    /**
     * Restore the specified soft-deleted comment to its original state.
     *
     * @param  int  $id  The id of the comment to be restored.
     * @return string 'Success' if the comment was successfully restored, 'Failure' otherwise.
     */
    public function restore($id)
    {
        $exists = ReactionType::query()->onlyTrashed()->where('id', $id)->exists();
        if (! $exists) {
            return 'Failure: Reaction Type not deleted';
        }
        $restored = ReactionType::query()->onlyTrashed()->where('id', $id)->restore();

        return $restored ? 'Success' : 'Failure';
    }

    /**
     * Permanently delete the specified reaction type.
     *
     * @param  int  $id  The id of the reaction type to be permanently deleted.
     * @return string 'Success' if the reaction type was successfully permanently deleted, 'Failure' otherwise.
     */
    public function force_delete($id)
    {
        $exists = ReactionType::query()->onlyTrashed()->where('id', $id)->exists();
        if (! $exists) {
            return 'Failure: ReactionType not deleted';
        }
        $force_deleted = ReactionType::query()->onlyTrashed()->where('id', $id)->forceDelete();

        return $force_deleted ? 'Success' : 'Failure';
    }
}
