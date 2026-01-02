<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use App\Models\PostLike;
use App\Models\User;

class PostLikeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id');
        $posts = Post::pluck('id');

        $likes = collect();

        while ($likes->count() < 100) {
            $user_id = $users->random();
            $post_id = $posts->random();

            if (!$likes->contains(fn($like) => $like['user_id'] === $user_id && $like['post_id'] === $post_id)) {
                $likes->push([
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        PostLike::insert($likes->toArray());
    }
}
