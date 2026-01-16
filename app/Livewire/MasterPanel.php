<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\PostReport;
use App\Models\User;
use App\Models\UserReport;
use Illuminate\Support\Facades\Auth;

class MasterPanel extends Component
{
    public $tab = 'role';
    public $search = '';
    public $sort = 'reports';
    public $filterRole = 'all';
    public $showBanned = true;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        if (Auth::user()->role !== 'master') {
            abort(403);
        }
    }

    public function clearUserReports($userId)
    {
        UserReport::where('reported_id', $userId)->delete();
        $this->dispatch('toast', ['message' => 'DISMISSED all reports.', 'type' => 'info']);
    }

    public function unbanUser($userId)
    {
        $user = User::find($userId);
        if (!$user || $user->isMaster()) return;

        $user->update(['is_banned' => false]);
        $this->dispatch('toast', ['message' => 'REMOVE User ban.', 'type' => 'success']);
    }

    public function setTab($tab)
    {
        if (in_array($tab, ['post', 'archived', 'role'])) {
            $this->tab = $tab;
        }
    }

    public function applyFilters() {}

    public function resetFilters()
    {
        $this->search = '';
        $this->filterRole = 'all';
        $this->showBanned = true;

        $this->dispatch('refresh');
    }

    public function resetSort()
    {
        $this->sort = 'reports';

        $this->dispatch('refresh');
    }

    public function resetAll()
    {
        $this->search = '';
        $this->filterRole = 'all';
        $this->showBanned = true;
        $this->sort = 'reports';

        $this->dispatch('refresh');
        if (method_exists($this, 'emit')) {
            $this->emit('resetComplete');
        }
    }

    public function restorePost($postId)
    {
        $post = Post::find($postId);
        if (!$post) return;
        $hasReports = PostReport::where('post_id', $postId)->exists();
        $post->update(['status' => $hasReports ? 'reported' : 'active']);
        $this->dispatch('toast', ['message' => 'RESTORE post.', 'type' => 'success']);
    }

    public function archivePost($postId)
    {
        $post = Post::find($postId);
        if (!$post) return;
        $post->update(['status' => 'archived']);
        $this->dispatch('toast', ['message' => 'Post ARCHIVED.', 'type' => 'error']);
    }

    public function dismissPostReport($postId)
    {
        PostReport::where('post_id', $postId)->delete();
        $post = Post::find($postId);
        if ($post) $post->update(['status' => 'active', 'reports_count' => 0]);
        $this->dispatch('toast', ['message' => 'DISMISS post report.', 'type' => 'info']);
    }

    public function banUser($userId)
    {
        $user = User::find($userId);
        if (!$user || $user->isMaster() || $user->is_banned) return;

        $user->update(['is_banned' => true]);
        $this->dispatch('toast', ['message' => 'User BANNED.', 'type' => 'error']);
    }

    public function promoteUser($userId)
    {
        $user = User::find($userId);
        if (!$user || $user->isMaster() || $user->is_banned) return;

        $hasReports = UserReport::where('reported_id', $userId)->exists();
        if ($hasReports) return;

        $user->update(['role' => User::ROLE_MODERATOR]);
        $this->dispatch('toast', ['message' => 'User PROMOTED to Moderator.', 'type' => 'success']);
    }

    public function demoteUser($userId)
    {
        $user = User::find($userId);
        if (!$user || $user->isMaster()) return;

        $user->update(['role' => User::ROLE_USER]);
        $this->dispatch('toast', ['message' => 'Moderator DEMOTED to User.', 'type' => 'warning']);
    }

    public function render()
    {
        $posts = Post::where('status', 'reported')
            ->with('author')
            ->withCount('reporters')
            ->latest()
            ->get();

        $archivedPosts = Post::where('status', 'archived')
            ->with('author')
            ->withCount('reporters')
            ->orderByDesc('updated_at')
            ->get();

        $usersQuery = User::where('role', '!=', 'master')
            ->withCount('reportsReceived');

        if ($this->search) {
            $search = '%' . $this->search . '%';
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                    ->orWhere('email', 'like', $search);
            });
        }

        if ($this->filterRole && $this->filterRole !== 'all') {
            $usersQuery->where('role', $this->filterRole);
        }

        if (!$this->showBanned) {
            $usersQuery->where('is_banned', false);
        }

        switch ($this->sort) {
            case 'latest':
                $usersQuery->orderByDesc('created_at');
                break;
            case 'alpha':
                $usersQuery->orderBy('name');
                break;
            case 'role':
                $usersQuery->orderBy('role')->orderBy('name');
                break;
            case 'reports':
            default:
                $usersQuery->orderByDesc('reports_received_count');
                break;
        }

        $roleUsers = $usersQuery->get();

        return view('livewire.master-panel', [
            'posts' => $posts,
            'archivedPosts' => $archivedPosts,
            'roleUsers' => $roleUsers
        ]);
    }
}
