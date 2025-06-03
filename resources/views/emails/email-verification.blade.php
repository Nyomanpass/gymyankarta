<!-- filepath: c:\laragon\www\gymyankarta\resources\views\emails\email-verification.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #4A90E2;">GYMYAKARTA</h1>
        </div>
        
        <h2>Halo {{ $user->name }}!</h2>
        
        <p>Terima kasih telah mendaftar di GYMYAKARTA. Untuk mengaktifkan akun Anda, silakan klik tombol verifikasi di bawah ini:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('email.verify', ['token' => $token]) }}" 
               style="background-color: #4A90E2; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Verifikasi Email
            </a>
        </div>
        
        <p>Jika tombol tidak berfungsi, Anda dapat menyalin dan menempelkan URL berikut ke browser Anda:</p>
        <p style="word-break: break-all; color: #666;">{{ route('email.verify', ['token' => $token]) }}</p>
        
        <p><strong>Catatan:</strong> Link verifikasi ini akan kedaluwarsa dalam 24 jam.</p>
        
        <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
        
        <p style="font-size: 12px; color: #666;">
            Jika Anda tidak membuat akun ini, abaikan email ini.
        </p>
    </div>
</body>
</html>