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
        $users = User::pluck('id')->toArray();

        Post::query()->chunk(50, function ($posts) use ($users) {
            foreach ($posts as $post) {
                $likeUsers = collect($users)
                    ->shuffle()
                    ->take(rand(3, min(10, count($users))));

                foreach ($likeUsers as $userId) {
                    PostLike::firstOrCreate([
                        'user_id' => $userId,
                        'post_id' => $post->id,
                    ]);
                }

                $post->update([
                    'likes_count' => PostLike::where('post_id', $post->id)->count(),
                ]);
            }
        });
    }
}
