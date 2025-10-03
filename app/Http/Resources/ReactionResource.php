<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'reaction_id' => $this->id,
            'reactable_type' => $this->reactable_type, // Post, Comment, etc.
            'reactable_id' => $this->reactable_id,
            'user' => UserResource::collection($this->whenLoaded('user')),
            'reaction_type' => ReactionTypeResource::collection($this->whenLoaded('reactionType')),
            'reacted_at' => $this->created_at->diffForHumans(),
        ];
    }
}
