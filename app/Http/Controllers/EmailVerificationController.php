<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailVerificationController extends Controller
{
    public function verify($token)
    {
        $verification = DB::table('email_verification_tokens')
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return redirect()->route('login')->with('error', 'Token verifikasi tidak valid atau telah kedaluwarsa.');
        }

        $user = User::where('email', $verification->email)->first();
        if ($user) {
            $user->update([
                'status' => 'pending_admin_verification',
                'email_verified_at' => now(),
            ]);

            DB::table('email_verification_tokens')->where('token', $token)->delete();

            return redirect()->route('login')->with('message', 'Email berhasil diverifikasi. Silakan tunggu verifikasi admin.');
        }

        return redirect()->route('login')->with('error', 'Pengguna tidak ditemukan.');
    }
}
