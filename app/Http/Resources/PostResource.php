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
            'title' => $this->title,
            'content' => $this->body,

            'post_status' => $this->post_status->type,

            'user' => UserResource::make($this->whenLoaded('user')),

            'comments' => CommentResource::collection($this->whenLoaded('comments')),

            'from' => $this->updated_at->diffForHumans(),
        ];
    }
}
