<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ForumPage extends Component
{
    use WithFileUploads;

    public $posts = [];
    public $picture = null;
    public $newComment = [];
    public $editingPostId = null;
    public $editingCaption = '';
    public $filter = 'recent';

    protected $listeners = [
        'postAdded' => 'loadPosts',
        'postLiked' => 'syncPostLike',
        'commentAdded' => 'refreshPostComments',
    ];

    public function mount()
    {
        $this->loadPosts();
    }

    public function render()
    {
        return view('livewire.forum-page');
    }

    public function updatedFilter()
    {
        $this->loadPosts();
    }

    public function setFilter($type)
    {
        $this->filter = $type;
        $this->loadPosts();
    }


    public function loadPosts()
    {
        $query = Post::with(['user', 'comments.user', 'likes'])
            ->withCount(['likes', 'comments']);

        if ($this->filter === 'own') {
            $query->where('user_id', Auth::id());
        } elseif ($this->filter === 'popular') {
            $query->orderByDesc('likes_count')->orderByDesc('comments_count');
        } else {
            $query->latest();
        }

        $this->posts = $query->get()->map(fn($post) => tap($post, function ($p) {
            $p->canEdit = $p->user_id === Auth::id();
            $p->canDelete = $p->user_id === Auth::id();
        }));
    }


    public function syncPostLike($payload)
    {
        foreach ($this->posts as $p) {
            if ($p->id === $payload['postId']) {
                $p->likes_count = $payload['likesCount'];
                break;
            }
        }
    }

    public function refreshPostComments($postId)
    {
        foreach ($this->posts as $index => $post) {
            if ($post->id == $postId) {
                $this->posts[$index] = Post::with(['user', 'comments.user', 'likes'])
                    ->withCount(['likes', 'comments'])
                    ->find($postId);
                $this->posts[$index]->canEdit = $post->user_id === Auth::id();
                $this->posts[$index]->canDelete = $post->user_id === Auth::id();
                break;
            }
        }
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

        $this->validate([
            'editingCaption' => 'required|max:120',
        ]);

        $post->update(['caption' => $this->editingCaption]);
        $this->cancelEdit();
        $this->loadPosts();
    }

    public function cancelEdit()
    {
        $this->editingPostId = null;
        $this->editingCaption = '';
    }

    public function deletePost($postId)
    {
        Log::info("Delete clicked for post: {$postId}");
        $post = Post::find($postId);
        if (!$post || $post->user_id !== Auth::id()) return;

        if ($post->picture) Storage::disk('public')->delete($post->picture);
        $post->delete();
        $this->loadPosts();
    }

    public function reportPost($postId)
    {
        session()->flash('message', 'Post has been reported to administrators.');
    }

    public function removeImage()
    {
        $this->picture = null;
    }
}
