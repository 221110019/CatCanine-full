<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;

class ForumLikesCounter extends Component
{
    public $post;
    public $liked = false;
    public $likesCount = 0;

    public function mount($post)
    {
        $this->post = is_object($post) ? $post : Post::findOrFail($post);
        $this->likesCount = $this->post->likes_count;
        $this->liked = $this->post->likes()->where('user_id', Auth::id())->exists();
    }


    public function toggleLike()
    {
        if (!Auth::check()) return;

        $like = PostLike::where('post_id', $this->post->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($like) {
            $like->delete();
            $this->post->decrement('likes_count');
            $this->liked = false;
            $this->likesCount--;
        } else {
            PostLike::create([
                'post_id' => $this->post->id,
                'user_id' => Auth::id(),
            ]);
            $this->post->increment('likes_count');
            $this->liked = true;
            $this->likesCount++;
        }
    }


    public function render()
    {
        return view('livewire.forum-likes-counter');
    }
}
