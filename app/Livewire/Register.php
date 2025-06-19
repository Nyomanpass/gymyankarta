<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\User;

use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Register extends Component
{
    #[Layout('components.layouts.auth')]

    // form properties
    public $name;
    public $email;
    public $username;
    public $nomor_telepon;
    public $password;


    protected $rules = [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users',
        'email' => 'required|string|email|max:255|unique:users',
        'nomor_telepon' => 'nullable|string|max:20',
        'password' => 'required|string|min:8',
    ];

    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique' => 'Username sudah digunakan.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
    ];

    public function render()
    {
        return view('livewire.register');
    }

    public function updatedEmail() {}

    public function register()
    {
        try {
            $this->validate();

            DB::beginTransaction();

            $user = User::create([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'nomor_telepon' => $this->nomor_telepon,
                'password' => Hash::make($this->password),
                'status' => 'pending_email_verification',
                'role' => 'member'
            ]);

            $token = Str::random(64);

            DB::table('email_verification_tokens')->insert([
                'email' => $this->email,
                'token' => $token,
                'expires_at' => now()->addHours(24),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Kirim email secara asynchronous menggunakan queue
            Mail::to($this->email)->send(new EmailVerification($user, $token));

            DB::commit();

            session()->flash('success', 'Registrasi berhasil! Email verifikasi sedang dikirim, silakan cek email Anda dalam beberapa menit.');

            $this->reset();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Registration failed', [
                'email' => $this->email,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
