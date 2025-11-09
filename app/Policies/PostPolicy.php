<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function create(User $user)
    {
        return !$user->is_banned;
    }

    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id || in_array($user->role, ['Master', 'Moderator']);
    }

    public function toggleLike(User $user)
    {
        return !$user->is_banned;
    }
}
