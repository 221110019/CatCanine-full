<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ForumCommentSection extends Component
{
    public Post $post;
    public $comments;
    public string $newComment = '';
    public int $showCount = 5;

    public function mount($post)
    {
        $this->post = is_object($post) ? $post : Post::findOrFail($post);
        $this->loadComments();
    }

    public function loadComments()
    {
        $this->comments = $this->post->comments()
            ->with('user')
            ->latest()
            ->take($this->showCount)
            ->get()
            ->reverse();
    }

    public function loadMore()
    {
        $this->showCount += 5;
        $this->loadComments();
    }

    public function addComment()
    {
        if (!Auth::check() || !$this->newComment) return;

        $this->post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $this->newComment,
        ]);

        $this->newComment = '';
        $this->loadComments();
    }

    public function render()
    {
        return view('livewire.forum-comment-section');
    }
}
