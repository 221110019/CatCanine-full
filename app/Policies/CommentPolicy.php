<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function create(User $user)
    {
        return !$user->is_banned;
    }

    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || in_array($user->role, ['Master', 'Moderator']);
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || in_array($user->role, ['Master', 'Moderator']);
    }
}
