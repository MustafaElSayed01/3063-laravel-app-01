<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'comment_id' => $this->comment_id,
            'reply_id' => $this->id,
            'reply' => $this->reply,
            'replied_at' => $this->created_at->diffForHumans(),
            'last_update' => $this->updated_at->diffForHumans(),
            'replied_by' => UserResource::make($this->whenLoaded('user')),
            'reply_reactions' => ReactionResource::collection($this->whenLoaded('reactions')),
        ];
    }
}
