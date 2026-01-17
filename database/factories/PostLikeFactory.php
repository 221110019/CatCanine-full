<?php

namespace Database\Factories;

use App\Models\PostLike;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostLikeFactory extends Factory
{
    protected $model = PostLike::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?: User::factory()->create();
        $post = Post::inRandomOrder()->first() ?: Post::factory()->create();


        return [
            'user_id' => $user?->id ?? User::factory(),
            'post_id' => $post?->id ?? Post::factory(),
        ];
    }

    public function configure()
    {
        return $this->unique(['user_id', 'post_id']);
    }
}
