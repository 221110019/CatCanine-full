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
<<<<<<< Updated upstream
<<<<<<< HEAD
    public $type = null;
=======
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
=======
    public $type = null;
>>>>>>> Stashed changes

    protected $rules = [
        'caption' => 'required|max:120',
        'picture' => 'nullable|image|mimes:jpg,webp,jpeg,png|max:2048',
<<<<<<< Updated upstream
<<<<<<< HEAD
        'type'    => 'nullable|in:cat,dog',
=======
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
=======
        'type'    => 'nullable|in:cat,dog',
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
<<<<<<< HEAD
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
=======
        $post = Post::create([
=======
        Post::create([
>>>>>>> Stashed changes
            'user_id' => Auth::id(),
            'caption' => $this->caption,
            'picture' => $path,
            'type'    => $this->type,
        ]);

        $this->dispatch('postAdded');
        $this->reset(['caption', 'picture', 'type']);
        $this->resetErrorBag();
        $this->resetValidation();
<<<<<<< Updated upstream

        return redirect(request()->header('Referer'));
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
=======
>>>>>>> Stashed changes
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
