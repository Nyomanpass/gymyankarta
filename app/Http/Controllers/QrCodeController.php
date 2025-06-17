<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class QrCodeController extends Controller
{
    public function generateAttendanceQr()
    {
        try {
            // Create QR data
            $qrData = [
                'type' => 'attendance',
                'gym_id' => 'gymyankarta',
                'token' => Str::random(32),
                'expires_at' => Carbon::now()->addMinutes(30)->timestamp,
                'created_at' => Carbon::now()->timestamp,
            ];

            $qrString = base64_encode(json_encode($qrData));

            // Generate QR Code as SVG
            $qrCode = QrCode::format('svg')
                ->size(200)
                ->errorCorrection('H')
                ->margin(2)
                ->generate($qrString);

            return response($qrCode, 200, [
                'Content-Type' => 'image/svg+xml',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
        } catch (\Exception $e) {
            // Log error for admin debugging
            Log::error('QR Code generation failed', [
                'error' => $e->getMessage(),
                'timestamp' => now()
            ]);

            // Return fallback QR
            return $this->generateFallbackQr($qrString ?? 'error_' . time());
        }
    }

    private function generateFallbackQr($data)
    {
        try {
            // Simple QR without advanced options
            $qrCode = QrCode::format('svg')->size(300)->generate($data);
            return response($qrCode, 200, ['Content-Type' => 'image/svg+xml']);
        } catch (\Exception $e) {
            // Return error placeholder
            return $this->generateErrorPlaceholder();
        }
    }

    private function generateErrorPlaceholder()
    {
        $svg = '
        <svg width="300" height="300" xmlns="http://www.w3.org/2000/svg">
            <rect width="300" height="300" fill="#f8f9fa" stroke="#dee2e6" stroke-width="2" rx="8"/>
            <circle cx="150" cy="120" r="30" fill="#dc3545" opacity="0.2"/>
            <text x="150" y="130" text-anchor="middle" font-family="Arial" font-size="24" fill="#dc3545">⚠</text>
            <text x="150" y="160" text-anchor="middle" font-family="Arial" font-size="14" fill="#6c757d">QR Code</text>
            <text x="150" y="180" text-anchor="middle" font-family="Arial" font-size="14" fill="#6c757d">Tidak Tersedia</text>
            <text x="150" y="210" text-anchor="middle" font-family="Arial" font-size="10" fill="#adb5bd">Silakan refresh halaman</text>
        </svg>';

        return response($svg, 200, ['Content-Type' => 'image/svg+xml']);
    }

    public function showQrCode()
    {
        return view('admin.qr-attendance');
    }
}
