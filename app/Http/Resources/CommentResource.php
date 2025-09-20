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
            'post_id' => $this->post->id,

            'comment_id' => $this->id,
            'comment' => $this->comment,

            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            
            'from' => $this->created_at->diffForHumans(),
            'last_updated' => $this->updated_at->diffForHumans(),
        ];
    }
}
