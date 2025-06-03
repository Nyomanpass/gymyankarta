<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    #[Layout('components.layouts.auth')]


    public $username;
    public $password;

    public function render()
    {
        return view('livewire.login');
    }

    public function login()
    {
        $this->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username tidak boleh kosong.',
            'password.required' => 'Password tidak boleh kosong.',
        ]);


        if (Auth::attempt([
            'username' => $this->username,
            'password' => $this->password
        ])) {
            session()->flash('message', 'Login berhasil!');
            return redirect()->route('dashboard');
        }

        session()->flash('error', 'Username atau password salah.');
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('message', 'Anda telah berhasil keluar.');
        return redirect()->route('login');
    }
}
