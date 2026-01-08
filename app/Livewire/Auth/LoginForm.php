<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginForm extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        $user = User::where('email', $this->email)->first();
        if (!$user || $user->isBanned()) {
            session()->flash('message', 'Your account has been banned.');
            return;
        }
        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])) {
            session()->regenerate();
            return redirect()->route('forum');
        }

        session()->flash('message', 'Invalid email or password.');
    }



    public function render()
    {
        return view('livewire.auth.login-form');
    }
}
