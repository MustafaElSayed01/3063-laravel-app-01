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

            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],

            'from' => $this->updated_at->diffForHumans(),
        ];
    }
}
