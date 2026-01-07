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
    public $tab = 'post'; // 'post', 'userReports', 'promotion'

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        if (Auth::user()->role !== 'master') {
            abort(403);
        }
    }

    public function setTab($tab)
    {
        if (in_array($tab, ['post', 'userReports', 'promotion'])) {
            $this->tab = $tab;
        }
    }

    // --- Post Reports ---
    public function archivePost($postId)
    {
        $post = Post::find($postId);
        if (!$post) return;

        $post->update(['status' => 'archived', 'reports_count' => 0]);
        PostReport::where('post_id', $postId)->delete();
    }

    public function dismissPostReport($postId)
    {
        PostReport::where('post_id', $postId)->delete();
        $post = Post::find($postId);
        if ($post) $post->update(['status' => 'active', 'reports_count' => 0]);
    }

    // --- User Reports ---
    public function banUser($userId)
    {
        $user = User::find($userId);
        if (!$user || $user->isMaster() || $user->is_banned) return;

        $user->update(['is_banned' => true]);
    }

    public function dismissUserReport($reportId)
    {
        UserReport::find($reportId)?->delete();
    }

    // --- User Promotion ---
    public function promoteUser($userId)
    {
        $user = User::find($userId);
        if (!$user || $user->isMaster() || $user->is_banned) return;

        $hasReports = UserReport::where('reported_id', $userId)->exists();
        if ($hasReports) return;

        $user->update(['role' => User::ROLE_MODERATOR]);
    }

    public function demoteUser($userId)
    {
        $user = User::find($userId);
        if (!$user || $user->isMaster()) return;

        $user->update(['role' => User::ROLE_USER]);
    }

    public function render()
    {
        $posts = Post::where('status', 'reported')
            ->with('author')
            ->withCount('reporters')
            ->latest()
            ->get();

        $userReports = UserReport::with(['reporter', 'reportedUser'])->latest()->get();

        $promotableUsers = User::where('role', '!=', 'master')
            ->where('is_banned', false)
            ->whereDoesntHave('reportsReceived')
            ->get();

        return view('livewire.master-panel', [
            'posts' => $posts,
            'userReports' => $userReports,
            'promotableUsers' => $promotableUsers
        ]);
    }
}
