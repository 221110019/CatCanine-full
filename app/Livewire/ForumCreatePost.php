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
        'picture' => 'nullable|image|mimes:jpg,webp,jpeg,png|max:2048',
        'type'    => 'nullable|in:cat,dog',
    ];

    public function createPost()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in first.');
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
        $this->reset(['caption', 'picture', 'type']);
        $this->resetErrorBag();
        $this->resetValidation();
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
