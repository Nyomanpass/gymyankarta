<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #f48801 0%, #ff9500 100%); padding: 40px 20px; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 32px; font-weight: bold; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                GYMYANKARTA
            </h1>
            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 16px;">
                Pusat Kebugaran Terpercaya
            </p>
        </div>

        <!-- Content -->
        <div style="padding: 40px 30px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f48801, #ff9500); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(244, 136, 1, 0.3);">
                    <span style="color: white; font-size: 36px;">✉️</span>
                </div>
                <h2 style="color: #333; margin: 0; font-size: 28px;">Halo {{ $user->name }}! 👋</h2>
            </div>

            <div style="background-color: #f8f9fa; padding: 25px; border-radius: 10px; border-left: 4px solid #f48801; margin-bottom: 30px;">
                <p style="margin: 0; color: #555; font-size: 16px; line-height: 1.6;">
                    Terima kasih telah bergabung dengan <strong>GYMYANKARTA</strong>! 🎉<br>
                    Untuk mengaktifkan akun Anda dan mulai perjalanan fitness, silakan verifikasi email Anda.
                </p>
            </div>

            <!-- CTA Button -->
            <div style="text-align: center; margin: 40px 0;">
                <a href="{{ route('email.verify', ['token' => $token]) }}" 
                   style="background: linear-gradient(135deg, #f48801 0%, #ff9500 100%); 
                          color: white; 
                          padding: 16px 40px; 
                          text-decoration: none; 
                          border-radius: 25px; 
                          display: inline-block; 
                          font-weight: bold; 
                          font-size: 16px;
                          box-shadow: 0 4px 15px rgba(244, 136, 1, 0.3);
                          transition: all 0.3s ease;">
                    🔐 Verifikasi Email Sekarang
                </a>
            </div>

            <!-- Alternative Link -->
            <div style="background-color: #fff3e0; padding: 20px; border-radius: 8px; margin: 30px 0;">
                <p style="margin: 0 0 10px 0; color: #666; font-size: 14px;">
                    <strong>🔗 Link alternatif:</strong> Jika tombol tidak berfungsi, salin URL berikut:
                </p>
                <p style="background-color: white; padding: 10px; border-radius: 5px; word-break: break-all; color: #f48801; font-family: monospace; font-size: 12px; margin: 0; border: 1px dashed #f48801;">
                    {{ route('email.verify', ['token' => $token]) }}
                </p>
            </div>

            <!-- Important Note -->
            <div style="background-color: #fff8f0; border: 1px solid #ffd700; border-radius: 8px; padding: 20px; margin: 30px 0;">
                <p style="margin: 0; color: #b8860b; font-size: 14px;">
                    <strong>⏰ Penting:</strong> Link verifikasi ini akan kedaluwarsa dalam <strong>24 jam</strong>.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color: #2c3e50; padding: 30px; text-align: center;">
            <p style="color: #bdc3c7; margin: 0 0 10px 0; font-size: 14px;">
                Jika Anda tidak membuat akun ini, abaikan email ini.
            </p>
            <p style="color: #7f8c8d; margin: 0; font-size: 12px;">
                © 2024 GYMYANKARTA. Semua hak dilindungi.
            </p>
            <div style="margin-top: 15px;">
                <span style="color: #95a5a6; font-size: 12px;">
                    📧 support@gymyankarta.com | 📞 (021) 123-4567
                </span>
            </div>
        </div>
    </div>
</body>
</html>