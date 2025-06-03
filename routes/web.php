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
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

    Route::get('/logout', [\App\Livewire\Login::class, 'logout'])->name('logout');
});
