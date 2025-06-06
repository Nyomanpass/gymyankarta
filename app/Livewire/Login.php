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

        $user = User::where('username', $this->username)->first();

        if ($user && Hash::check($this->password, $user->password)) {
            if ($user->status === 'active' || $user->status === 'frozen') {
                Auth::login($user);
                return redirect()->intended('/dashboard');
            } else {
                if ($user->status === 'pending_admin_verification') {
                    session()->flash('error', 'Lakukan pembayaran terlebih dahulu dan tunggu admin melakukan verifikasi.');
                } elseif ($user->status === 'inactive') {
                    session()->flash('error', 'Akun anda telah dinonaktifkan. Lakukan pembayaran bulanan untuk mengaktifkan akun kembali.');
                } else {
                    session()->flash('error', 'Status akun tidak valid.');
                }
                return;
            }
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
