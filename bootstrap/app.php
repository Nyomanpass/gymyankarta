<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        // 🕐 Membership check schedule
        $schedule->command('membership:check-status')
            ->dailyAt('00:01')                    // Setiap hari jam 00:01
            ->withoutOverlapping()                // Prevent multiple instances
            ->runInBackground()                   // Don't block other tasks
            ->appendOutputTo(storage_path('logs/membership-check.log'))
            ->emailOutputOnFailure('admin@gymyankarta.com'); // Optional

        // 🕐 Tambahkan schedule lain jika perlu
        // $schedule->command('backup:run')->weekly();
        // $schedule->command('queue:work')->everyMinute();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
