<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'post_id' => $this->post_id,
            'comment_id' => $this->id,
            'comment' => $this->comment,
            'commented_at' => $this->created_at->diffForHumans(),
            'last_update' => $this->updated_at->diffForHumans(),
            'commented_by' => UserResource::make($this->whenLoaded('user')),
            'comment_replies' => ReplyResource::collection($this->whenLoaded('replies')),
            'comment_reactions' => ReactionResource::collection($this->whenLoaded('reactions')),
        ];
    }
}
