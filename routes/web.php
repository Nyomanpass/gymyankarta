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

// Version polling must not extend a member's idle login session.
Route::get('/app-release', App\Http\Controllers\ApplicationReleaseController::class)
    ->withoutMiddleware([
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    ])->name('app.release');

// Protected routes
Route::middleware(['auth'])->group(function () {
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

        Route::get('/qr/generate', [App\Http\Controllers\QrCodeController::class, 'generateAttendanceQr'])->name('qr.generate');
        Route::post('/qr/rotate', [App\Http\Controllers\QrCodeController::class, 'rotate'])->name('qr.rotate');

        Route::get('/laporan/member', \App\Livewire\LaporanMember::class)->name('laporan.member');
        Route::get('/laporan/pendapatan', \App\Livewire\LaporanPendapatan::class)->name('laporan.pendapatan');
        Route::get('/reset-password', \App\Livewire\ResetPassword::class)->name('reset.password');
    });

    Route::get('/logout', [\App\Livewire\Login::class, 'logout'])->name('logout');
});
