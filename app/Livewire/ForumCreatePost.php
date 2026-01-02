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
<<<<<<< HEAD
    public $type = null;
=======
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc

    protected $rules = [
        'caption' => 'required|max:120',
        'picture' => 'nullable|image|mimes:jpg,webp,jpeg,png|max:2048',
<<<<<<< HEAD
        'type'    => 'nullable|in:cat,dog',
=======
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
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
            'user_id' => Auth::id(),
            'caption' => $this->caption,
            'picture' => $path,
        ]);

        $newPost = Post::with(['user', 'comments.user', 'likes'])
            ->withCount(['likes', 'comments'])
            ->find($post->id);

        $this->dispatch('postAdded');


        $this->reset(['caption', 'picture']);
        $this->resetErrorBag();
        $this->resetValidation();

        return redirect(request()->header('Referer'));
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
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
