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
            'reply_id' => $this->id,
            'reply' => $this->reply,
            'comment_id' => $this->comment_id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'from' => $this->created_at->diffForHumans(),
            'last_updated' => $this->updated_at->diffForHumans(),
        ];    }
}
