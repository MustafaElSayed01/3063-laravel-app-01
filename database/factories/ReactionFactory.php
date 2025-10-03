<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\ReactionType;
use App\Models\Reply;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reaction>
 */
class ReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reaction_type_id = ReactionType::inRandomOrder()->first()->id;

        $user_id = User::inRandomOrder()->first()->id;
        $reactable_type = $this->faker->randomElement(['post', 'comment', 'reply']);

        $reactable_id = match ($reactable_type) {
            'post' => Post::inRandomOrder()->first()->id,
            'comment' => Comment::inRandomOrder()->first()->id,
            'reply' => Reply::inRandomOrder()->first()->id,
        };

        $exists = Reaction::where('user_id', $user_id)->
            where('reactable_type', $reactable_type)->
            where('reactable_id', $reactable_id)
                ->get();

        if ($exists->count() > 0) {
            return $this->definition();
        }

        return [
            'user_id' => $user_id,
            'reactable_type' => $reactable_type,
            'reactable_id' => $reactable_id,
            'reaction_type_id' => $reaction_type_id,
        ];
    }
}
