<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostReport;
use App\Models\UserReport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ForumPage extends Component
{
    use WithFileUploads;

    public $filter = 'recent';
    public $search = "";
    public $editingPostId = null;
    public $editingCaption = '';

    protected $listeners = [
        'postAdded' => '$refresh',
        'postLiked' => '$refresh',
        'commentAdded' => '$refresh',
    ];

    public function setFilter($type)
    {
        $this->filter = $type;
        $this->search = '';
    }
    public function applySearch() {}

    public function render()
    {
        $this->search;
        return view('livewire.forum-page', [
            'posts' => $this->queryPosts()

        ]);
    }

    private function queryPosts()
    {
        $query = Post::with(['user', 'comments.user', 'likes'])
            ->withCount(['likes', 'comments']);
        $query->where('status', '!=', 'archived');
        $query = match ($this->filter) {
            'my post' => $query->where('user_id', Auth::id())->latest(),
            'liked' => $query->whereHas('likes', fn($q) => $q->where('user_id', Auth::id()))->latest(),
            'cat' => $query->where('type', 'cat')->latest(),
            'dog' => $query->where('type', 'dog')->latest(),
            'popular' => $query->orderByDesc('likes_count')->orderByDesc('comments_count'),
            default => $query->latest(),
        };

        if ($this->search !== '') {
            $query->where('caption', 'like', "%{$this->search}%");
        }

        return $query->get();
    }

    public function editPost($postId)
    {
        $post = Post::findOrFail($postId);
        if ($post->user_id !== Auth::id()) return;

        $this->editingPostId = $postId;
        $this->editingCaption = $post->caption;
    }

    public function updatePost($postId)
    {
        $post = Post::findOrFail($postId);
        if ($post->user_id !== Auth::id()) return;

        if (trim($this->editingCaption) === trim($post->caption)) {
            $this->cancelEdit();
            $this->dispatch('toast', ['message' => 'No changes detected.', 'type' => 'info']);

            return;
        }

        $this->validate([
            'editingCaption' => 'required|max:120',
        ]);

        $post->update([
            'caption' => $this->editingCaption
        ]);

        $this->dispatch('toast', ['message' => 'Post updated.', 'type' => 'warning']);
        $this->cancelEdit();
    }


    public function cancelEdit()
    {
        $this->editingPostId = null;
        $this->editingCaption = '';
    }

    public function archivePost($postId)
    {
        $post = Post::find($postId);
        if (!$post || $post->user_id !== Auth::id()) return;

        $post->update(['status' => 'archived']);
        $this->dispatch('toast', ['message' => 'Post deleted.', 'type' => 'error']);
    }

    public function reportPost($postId)
    {
        $post = Post::find($postId);
        if (!$post) return;
        if ($post->user_id === Auth::id()) return;
        $already = PostReport::where('post_id', $postId)
            ->where('user_id', Auth::id())
            ->exists();

        if ($already) return;
        PostReport::create([
            'user_id' => Auth::id(),
            'post_id' => $postId,
        ]);
        $post->timestamps = false;
        $post->increment('reports_count');
        $post->update(['status' => 'reported']);
        $post->timestamps = true;

        $this->dispatch('toast', ['message' => 'Post reported.', 'type' => 'error']);
    }
    public function reportUser($postId)
    {
        $post = Post::find($postId);
        if (!$post) return;

        if ($post->user_id === Auth::id()) return;

        $exists = UserReport::where('reporter_id', Auth::id())
            ->where('reported_id', $post->user_id)
            ->where('post_id', $postId)
            ->exists();

        if ($exists) return;

        UserReport::create([
            'reporter_id' => Auth::id(),
            'reported_id' => $post->user_id,
            'post_id'     => $postId,
        ]);

        $this->dispatch('toast', ['message' => 'User reported.', 'type' => 'soft']);
    }
}
