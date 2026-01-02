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
            throw new \Exception("No users found in database. Please create users first.");
        }

        return [
            'user_id' => $user->id,
            'caption' => $this->faker->realTextBetween(10, 120),
            'picture' => null,
            'likes_count' => $this->faker->numberBetween(0, 20),
            'reports_count' => $this->faker->numberBetween(0, 5),
        ];
    }
}
