<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'post_id' => $this->id,
            'post_title' => $this->title,
            'post_content' => $this->body,
            'post_status' => $this->post_status->type,
            'posted_at' => $this->created_at->diffForHumans(),
            'last_update' => $this->updated_at->diffForHumans(),
            'posted_by' => UserResource::make($this->whenLoaded('user')),
            'post_comments' => CommentResource::collection($this->whenLoaded('comments')),
            'post_reactions' => ReactionResource::collection($this->whenLoaded('reactions')),
        ];
    }
}
