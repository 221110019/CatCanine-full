<?php

namespace App\Livewire;

use App\Models\Post;
<<<<<<< Updated upstream
<<<<<<< HEAD
use App\Models\PostReport;
use App\Models\UserReport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
=======
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
=======
use App\Models\PostReport;
use App\Models\UserReport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
>>>>>>> Stashed changes
use Illuminate\Support\Facades\Storage;

class ForumPage extends Component
{
    use WithFileUploads;

<<<<<<< Updated upstream
<<<<<<< HEAD
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
=======
    public $posts = [];
    public $picture = null;
    public $newComment = [];
=======
    public $filter = 'recent';
    public $search = "";
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
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
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
=======
        return $query->get();
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
<<<<<<< HEAD
=======
>>>>>>> Stashed changes
        if (trim($this->editingCaption) === trim($post->caption)) {
            $this->cancelEdit();
            return;
        }

<<<<<<< Updated upstream
=======
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
=======
>>>>>>> Stashed changes
        $this->validate([
            'editingCaption' => 'required|max:120',
        ]);

<<<<<<< Updated upstream
<<<<<<< HEAD
=======
>>>>>>> Stashed changes
        $post->update([
            'caption' => $this->editingCaption
        ]);

<<<<<<< Updated upstream
        $this->cancelEdit();
    }


=======
        $post->update(['caption' => $this->editingCaption]);
=======
>>>>>>> Stashed changes
        $this->cancelEdit();
    }

<<<<<<< Updated upstream
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
=======

>>>>>>> Stashed changes
    public function cancelEdit()
    {
        $this->editingPostId = null;
        $this->editingCaption = '';
    }

<<<<<<< Updated upstream
<<<<<<< HEAD
    public function archivePost($postId)
    {
        $post = Post::find($postId);
        if (!$post || $post->user_id !== Auth::id()) return;

        $post->update(['status' => 'archived']);
        $this->dispatch('$refresh');
=======
    public function deletePost($postId)
=======
    public function archivePost($postId)
>>>>>>> Stashed changes
    {
        $post = Post::find($postId);
        if (!$post || $post->user_id !== Auth::id()) return;

<<<<<<< Updated upstream
        if ($post->picture) Storage::disk('public')->delete($post->picture);
        $post->delete();
        $this->loadPosts();
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
=======
        $post->update(['status' => 'archived']);
        $this->dispatch('$refresh');
>>>>>>> Stashed changes
    }

    public function reportPost($postId)
    {
<<<<<<< Updated upstream
<<<<<<< HEAD
=======
>>>>>>> Stashed changes
        $post = Post::find($postId);
        if (!$post) return;
        if ($post->user_id === Auth::id()) return;
        $already = PostReport::where('post_id', $postId)
            ->where('user_id', Auth::id())
            ->exists();
<<<<<<< Updated upstream

        if ($already) return;
        PostReport::create([
            'user_id' => Auth::id(),
            'post_id' => $postId,
        ]);
        $post->timestamps = false;
        $post->increment('reports_count');
        $post->update(['status' => 'reported']);
        $post->timestamps = true;

        session()->flash('message', 'Reported.');
        $this->dispatch('$refresh');
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

        session()->flash('message', 'User reported.');
        $this->dispatch('$refresh');
=======
        session()->flash('message', 'Post has been reported to administrators.');
    }
=======
>>>>>>> Stashed changes

        if ($already) return;
        PostReport::create([
            'user_id' => Auth::id(),
            'post_id' => $postId,
        ]);
        $post->timestamps = false;
        $post->increment('reports_count');
        $post->update(['status' => 'reported']);
        $post->timestamps = true;

        session()->flash('message', 'Reported.');
        $this->dispatch('$refresh');
    }
    public function reportUser($postId)
    {
<<<<<<< Updated upstream
        $this->picture = null;
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
=======
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

        session()->flash('message', 'User reported.');
        $this->dispatch('$refresh');
>>>>>>> Stashed changes
    }
}
