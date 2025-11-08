<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index()
    {
        $filter = request('filter', 'recent');

        $query = Post::with(['user', 'comments.user', 'likes'])
            ->withCount(['likes', 'comments']);

        if ($filter === 'own') {
            $query->where('user_id', Auth::id())->latest();
        } elseif ($filter === 'popular') {
            $query->orderByDesc('likes_count')->orderByDesc('comments_count');
        } else {
            $query->latest();
        }

        $posts = $query->get();

        return view('forum', compact('posts', 'filter'));
    }
}
