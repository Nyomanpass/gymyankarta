<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Str;

class AttendanceQr
{
    private const KEY = 'attendance_qr_token';

    public function payload(): string
    {
        $setting = Setting::firstOrCreate(
            ['setting_key' => self::KEY],
            ['setting_value' => Str::random(40), 'description' => 'QR absensi aktif']
        );

        return 'GYMYANKARTA:ABSEN:'.$setting->setting_value;
    }

    public function rotate(): void
    {
        Setting::set(self::KEY, Str::random(40), 'QR absensi aktif');
    }

    public function valid($payload): bool
    {
        $token = Setting::get(self::KEY);

        return is_string($payload) && is_string($token) && $token !== ''
            && hash_equals('GYMYANKARTA:ABSEN:'.$token, $payload);
    }
}
