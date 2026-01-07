<?php

namespace App\Livewire\Auth;

<<<<<<< HEAD
use Illuminate\Http\Request;
=======
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
use Livewire\Component;

class RegisterForm extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';

    protected $rules = [
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:255',
        'password' => 'required|min:6',
    ];

    public function register()
    {
        $this->validate();

<<<<<<< HEAD
        $internal = Request::create('/api/register', 'POST', [
=======
        $internal = \Illuminate\Http\Request::create('/api/register', 'POST', [
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $response = app()->handle($internal);
        $data = json_decode($response->getContent(), true);

        if (isset($data['token'])) {
            $this->reset(['name', 'email', 'password']);
            $this->dispatch('clearValidationHints');
            session()->flash('message', 'Registration success, you can login now.');
            return;
        }


        session()->flash('message', $data['message'] ?? 'Registration failed.');
    }




    public function render()
    {
        return view('livewire.auth.register-form');
    }
}
