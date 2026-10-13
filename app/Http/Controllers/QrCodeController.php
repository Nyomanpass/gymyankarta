<?php

namespace App\Http\Controllers;

use App\Services\AttendanceQr;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generateAttendanceQr(Request $request, AttendanceQr $qr)
    {
        $svg = QrCode::format('svg')->size(1000)->errorCorrection('M')
            ->margin(4)->generate($qr->payload());

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'no-store, private',
            'Content-Disposition' => ($request->boolean('download') ? 'attachment' : 'inline').'; filename="qr-absensi-gymyankarta.svg"',
        ]);
    }

    public function rotate(AttendanceQr $qr)
    {
        $qr->rotate();

        return redirect()->route('qr.attendance')->with('status', 'QR baru siap. Unduh dan ganti cetakan lama karena QR sebelumnya sudah tidak berlaku.');
    }

    public function showQrCode()
    {
        return response()->view('admin.qr-attendance')->header('Cache-Control', 'no-store, private');
    }
}
