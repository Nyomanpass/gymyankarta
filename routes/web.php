<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['guest'])->group(function () {

    Route::get('/login', \App\Livewire\Login::class)->name('login');
    Route::get('/register', \App\Livewire\Register::class)->name('register');
    Route::get('/email/verify/{token}', [\App\Http\Controllers\EmailVerificationController::class, 'verify'])->name('email.verify');
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/qr/generate', [App\Http\Controllers\QrCodeController::class, 'generateAttendanceQr'])
        ->name('qr.generate');

    Route::middleware(['role:member'])->group(function () {
        Route::get('/dashboard-member', \App\Livewire\DashboardMember::class)->name('dashboard.member');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

        Route::get('/kelola-pendapatan', \App\Livewire\KelolaPendapatan::class)->name('kelola.pendapatan');

        Route::get('/kelola-member', \App\Livewire\KelolaMember::class)->name('kelola.member');

        Route::get('/pengaturan-harga', \App\Livewire\PengaturanHarga::class)->name('pengaturan.harga');

        Route::get('/qr/attendance', [App\Http\Controllers\QrCodeController::class, 'showQrCode'])
            ->name('qr.attendance');

        Route::get('/qr/test', [App\Http\Controllers\QrCodeController::class, 'testQr'])
            ->name('qr.test');

        Route::get('/laporan/member', \App\Livewire\LaporanMember::class)->name('laporan.member');
        Route::get('/laporan/pendapatan', \App\Livewire\LaporanPendapatan::class)->name('laporan.pendapatan');
        Route::get('/reset-password', \App\Livewire\ResetPassword::class)->name('reset.password');
    });

    Route::get('/logout', [\App\Livewire\Login::class, 'logout'])->name('logout');
});
