<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostReport;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModeratorPanel extends Component
{
    public function render()
    {
        return view('livewire.moderator-panel', [
            'posts' => Post::where('status', 'reported')
                ->with('author')
                ->withCount('reporters')
                ->latest()
                ->get()
        ]);
    }
    public function mount()
    {
        if (!in_array(Auth::user()->role, ['moderator', 'master'])) {
            abort(403);
        }
    }


    public function archive($postId)
    {
        Post::whereId($postId)->update([
            'status' => 'archived',
            'reports_count' => 0,
        ]);

        PostReport::where('post_id', $postId)->delete();
    }

    public function dismiss($postId)
    {
        Post::whereId($postId)->update([
            'status' => 'active',
            'reports_count' => 0,
        ]);

        PostReport::where('post_id', $postId)->delete();
    }
}
