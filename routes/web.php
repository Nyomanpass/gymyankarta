<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', \App\Livewire\Login::class)->name('login');
Route::get('/register', \App\Livewire\Register::class)->name('register');
Route::get('/email/verify/{token}', [\App\Http\Controllers\EmailVerificationController::class, 'verify'])->name('email.verify');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:member'])->group(function () {
        Route::get('/dashboard-member', \App\Livewire\DashboardMember::class)->name('dashboard.member');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

        Route::get('/kelola-pendapatan', \App\Livewire\KelolaPendapatan::class)->name('kelola.pendapatan');

        Route::get('/kelola-member', \App\Livewire\KelolaMember::class)->name('kelola.member');

        ROute::get('/pengaturan-harga', \App\Livewire\PengaturanHarga::class)->name('pengaturan.harga');
    });

    Route::get('/logout', [\App\Livewire\Login::class, 'logout'])->name('logout');
});
