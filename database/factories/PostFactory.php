<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first();
        if (!$user) {
            $user = User::factory()->create();
        }


        $type = $this->faker->randomElement(['cat', 'dog']);

        $catPosts = [
            'Anyone else have a cat that refuses cheap food?',
            'Why do cats get stressed so easily over small changes?',
            'Indoor cats seem healthier — agree or not?',
            'People say cats are low maintenance, but is that actually true?',
            'I think my cat may hates me'
        ];

        $dogPosts = [
            'Pomeranians are the best dog breed!!! I mean look at the walnut sized head, their walking style, and their smile, I mean look at their EVERYTHING!!!',
            'What protein works best for energetic dogs?',
            'Daily walks are non-negotiable for dogs, right?',
            'What training method worked fastest for your puppy?',
            'Do you think dogs understand human emotions?',
            'Royal Canine is actually not a premium brand for kibble.',
            'The world must admit that dogs are the best creature of all time.'
        ];


        return [
            'user_id' => $user->id,
            'type' => $type,
            'caption' => $type === 'cat'
                ? $this->faker->randomElement($catPosts)
                : $this->faker->randomElement($dogPosts),
            'picture' => null,
            'likes_count' => 0,
            'reports_count' => 0,
        ];
    }
}
