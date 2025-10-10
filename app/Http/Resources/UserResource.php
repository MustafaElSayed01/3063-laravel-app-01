<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->id,
            'user_name' => $this->name,
            'user_email' => $this->email,
            'user_mobile' => $this->mobile,
            'user_roles' => $this->roles,
            'user_status' => $this->is_active,
            'joined' => $this->created_at->diffForHumans(),
            'email_verified' => $this->email_verified_at,
            'user_posts' => PostResource::collection($this->whenLoaded('posts')),
            'user_comments' => CommentResource::collection($this->whenLoaded('comments')),
            'user_replies' => ReplyResource::collection($this->whenLoaded('replies')),
            'user_reactions' => ReactionResource::collection($this->whenLoaded('reactions')),
        ];
    }
}
