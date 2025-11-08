<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $userId = request()->user()?->id;
        $posts = Post::with(['user', 'comments.user'])->orderByDesc('created_at')->get();

        if ($userId) {
            $posts->transform(function ($post) use ($userId) {
                $post->liked = PostLike::where('user_id', $userId)
                    ->where('post_id', $post->id)
                    ->exists();
                return $post;
            });
        }

        return $posts;
    }

    public function show($id)
    {
        return Post::findOrFail($id);
    }

    public function store(PostRequest $request)
    {
        $this->authorize('create', Post::class);
        $data = $request->validated();
        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('posts', 'public');
        }
        $data['user_id'] = $request->user()->id;
        $post = Post::create($data);
        return response()->json($post, 201);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);
        $data = $request->validated();
        if ($request->hasFile('picture')) {
            if ($post->picture) Storage::disk('public')->delete($post->picture);
            $data['picture'] = $request->file('picture')->store('posts', 'public');
        }
        $post->update($data);
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);
        if ($post->picture) Storage::disk('public')->delete($post->picture);
        $post->delete();
        return response()->noContent();
    }

    public function toggleLike($id)
    {
        $post = Post::findOrFail($id);
        $userId = Auth::id();

        $like = $post->likes()->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
            $post->decrement('likes_count');
        } else {
            $post->likes()->create(['user_id' => $userId]);
            $post->increment('likes_count');
        }

        $post->refresh();
    }
}
