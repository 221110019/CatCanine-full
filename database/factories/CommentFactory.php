<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->firstOrFail();
        $post = Post::inRandomOrder()->firstOrFail();

        $support = [
            'Yeah, I’ve seen the same with my pet.',
            '100% agree. This matches my experience.',
            'Glad someone finally said this.',
            'This actually worked for me too.',
        ];

        $attack = [
            'I don’t think that’s accurate.',
            'That hasn’t been true in my case.',
            'I strongly disagree with this take.',
            'That sounds more like a myth.',
        ];

        $neutral = [
            'It really depends on the animal.',
            'Every pet reacts differently.',
            'Interesting point, not sure I fully agree.',
        ];


        $content = match ($this->faker->randomElement(['support', 'attack', 'neutral'])) {
            'support' => $this->faker->randomElement($support),
            'attack' => $this->faker->randomElement($attack),
            default => $this->faker->randomElement($neutral),
        };

        return [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => $content,
        ];
    }
}
