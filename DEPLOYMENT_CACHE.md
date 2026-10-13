# Pembaruan website dan cache

Middleware `PreventHtmlCaching` memberi respons HTML `Cache-Control: private,
no-store, no-cache, max-age=0, must-revalidate`. Halaman baru tidak disimpan dalam
HTTP cache. Cookie login tidak dihapus. CSS/JS tetap menggunakan URL berversi
dari `@vite` dan manifest build.

## Setiap deployment

1. Siapkan release baru, pasang dependency sesuai lockfile, lalu jalankan
   `npm ci` dan `npm run build` di folder release/build, bukan folder yang sedang
   melayani pengunjung. Build Vite bisa menghapus isi build sebelumnya.
2. Deploy kode PHP, `public/build/manifest.json`, `public/build/release.json`, dan seluruh aset build yang
   sesuai sebagai satu release. Pastikan `public/hot` dari development tidak
   ikut terunggah. Jangan menjalankan `npm run dev` untuk production.
3. Pertahankan aset build release sebelumnya selama masa transisi untuk tab
   yang masih terbuka. Salin aset lama yang belum ada ke folder aset release
   baru tanpa menimpa manifest baru. Jangan menghapus aset lama saat switch.
4. Setelah konfigurasi production tersedia di release baru, jalankan:

   ```sh
   php artisan config:cache
   php artisan view:cache
   ```

   Aktifkan release baru secara atomik jika hosting mendukung symlink release.
   Jika OPcache tidak mengecek perubahan file, reload PHP-FPM sesuai konfigurasi
   hosting. Restart queue worker jika deployment mengubah kode job.
5. Jika memakai CDN atau Nginx FastCGI cache, jangan paksa cache untuk HTML,
   login, dashboard, atau endpoint Livewire. Pastikan header aplikasi dihormati.
   Purge HTML lama di cache proxy/CDN saat pertama memasang perubahan ini.
   Aset bernama hash di `/build/assets/` boleh memakai cache panjang/immutable;
   jangan menerapkan kebijakan itu pada semua URL atau file tanpa versi.

`php artisan cache:clear` hanya menghapus cache aplikasi di server, bukan cache
browser. Tidak perlu menghapus cookie atau seluruh cache browser setiap update.

## Verifikasi setelah upload

```sh
curl -sS -D - -o /dev/null https://yankartagym.com/
curl -sS -D - -o /dev/null https://yankartagym.com/login
```

Pastikan respons HTML memuat `Cache-Control` dengan `private` dan `no-store`.
Buka halaman di browser dan pastikan CSS/JS `/build/assets/` merespons 200,
tidak 404, dan URL-nya sesuai manifest release terbaru.

Header baru tidak dapat menarik kembali HTML yang sudah tersimpan di browser
sebelum deployment dan belum menghubungi server. Untuk klien yang masih macet,
coba sekali URL baru `https://yankartagym.com/?release=20260930` atau tab samaran.
Query baru membantu melewati cache URL lama, tetapi bukan solusi jaringan atau
jaminan melewati semua aturan CDN. Tab yang sudah terbuka perlu dimuat ulang.

Uji juga di HP klien dengan Wi-Fi dan data seluler. Tailwind CSS 4 membutuhkan
Safari 16.4+; kebijakan cache ini tidak menambah dukungan untuk iOS lama dan
tidak membuktikan penyebab layar putih telah teratasi.

## Deteksi versi dan pemulihan sesi

Setiap `npm run build` menghasilkan `public/build/release.json` dengan ID baru,
termasuk ketika perubahan hanya pada PHP/Blade. Jalankan build untuk setiap release.
Layout login dan dashboard menyertakan ID release saat halaman dirender.
Browser memeriksa endpoint GET `/app-release` setiap 60 detik saat tab terlihat,
dan saat kembali ke tab atau kembali online. Endpoint tidak memakai sesi, sehingga
pengecekan versi tidak memperpanjang waktu login yang sedang idle.

Versi berubah: halaman yang bersih dimuat ulang. Jika ada isian, aksi Livewire,
keranjang, atau pemindai kamera, tampil pemberitahuan untuk muat ulang secara manual.
Formulir yang belum tersimpan tidak akan dikirim ulang otomatis. Error Livewire 419
menampilkan pemberitahuan pemulihan sesi melalui muat ulang. Password tidak disimpan
ke localStorage maupun sessionStorage.

Member yang masih login dan membuka `/login` diarahkan ke dashboard member;
admin ke dashboard admin. Logout menginvalidasi sesi dan memperbarui token CSRF.
Alpine memakai versi bawaan Livewire, tanpa memuat instance kedua dari CDN.

Halaman yang sudah terbuka sebelum fitur ini dipasang belum memiliki kode pemeriksa
versi: muat ulang sekali untuk mengaktifkannya. Tidak ada penghapusan massal cookie,
riwayat browser, data member, atau data transaksi.

Pengujian terarah:

```sh
php artisan test --compact tests/Feature/SessionRecoveryTest.php tests/Feature/AttendanceQrTest.php
node --test tests/JavaScript/session-refresh.test.mjs
```
