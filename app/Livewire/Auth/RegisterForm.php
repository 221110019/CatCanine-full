<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterForm extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';

    protected $rules = [
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|min:6',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'user',
        ]);

        if ($user) {
            $this->reset(['name', 'email', 'password']);
            session()->flash('message', 'Registration successful, you can now log in.');
        } else {
            session()->flash('message', 'Registration failed.');
        }
    }

    public function render()
    {
        return view('livewire.auth.register-form');
    }
}
