<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ForumCreatePost extends Component
{
    use WithFileUploads;

    public $caption = '';
    public $picture = null;
    public $type = null;
    protected $rules = [
        'caption' => 'required|max:120',
        'picture' => 'nullable|image|mimes:jpg,webp,jpeg,png|max:10240',
        'type'    => 'nullable|in:cat,dog',
    ];

    public function createPost()
    {
        if (!Auth::check()) {
            $this->dispatch('toast', ['message' => 'Please log in first.', 'type' => 'error']);
            return;
        }

        $this->validate();

        $path = $this->picture
            ? $this->picture->store('posts', 'public')
            : null;

        Post::create([
            'user_id' => Auth::id(),
            'caption' => $this->caption,
            'picture' => $path,
            'type'    => $this->type,
        ]);

        $this->dispatch('postAdded');
        $this->dispatch('toast', ['message' => 'Post created.', 'type' => 'success']);
        $this->reset(['caption', 'picture', 'type']);
        $this->resetErrorBag();
        $this->resetValidation();
        return redirect(request()->header('Referer'));
    }

    public function removeImage()
    {
        $this->picture = null;
    }

    public function render()
    {
        return view('livewire.forum-create-post');
    }
}
