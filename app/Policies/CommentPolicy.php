<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentPolicy
{
    private function hasAccess(User $user, Comment $comment)
    {
        // Check if the user is the owner of the comment
        $isOwner = $user->id === $comment->user_id;

        // Check if the user is the owner of the post that has the comment
        $post = Post::where('id', $comment->post_id)->first();

        // Check if the user is the owner of the post
        $isPostOwner = $user->id === $post->user_id;

        return $isOwner || $isPostOwner;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment): bool
    {
        return self::hasAccess($user, $comment);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return self::hasAccess($user, $comment);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return self::hasAccess($user, $comment);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return self::hasAccess($user, $comment);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return self::hasAccess($user, $comment);
    }
}
