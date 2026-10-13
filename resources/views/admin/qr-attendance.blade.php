<x-layouts.dashboard>
    @push('styles')
    <style>
        .attendance-page{max-width:1500px;margin:auto}.attendance-page .qr-panel{background:#fff;border:1px solid var(--color-warna-100);border-radius:20px;box-shadow:0 3px 14px #273f4f04}.attendance-page .qr-button{display:inline-flex;align-items:center;justify-content:center;gap:9px;padding:12px 18px;border:1px solid var(--color-warna-100);border-radius:12px;font-weight:600;font-size:14px;cursor:pointer;transition:background .15s}.attendance-page .qr-button:hover{background:var(--color-warna-50)}.attendance-page .qr-primary{background:var(--color-warna-400);border-color:var(--color-warna-400);color:white}.attendance-page .qr-primary:hover{background:var(--color-warna-500)}.attendance-page .qr-button:disabled{opacity:.45;cursor:wait}.attendance-page .qr-image{display:block;width:min(100%,580px);height:auto;margin:auto}.attendance-page [hidden]{display:none!important}
        @media print{
            @page{size:A4;margin:16mm}.attendance-page{max-width:none}.attendance-grid{display:block!important}.attendance-page .qr-panel{border:0;box-shadow:none;padding:0!important}.attendance-page .qr-image{width:160mm;max-width:100%;margin:10mm auto}.print-title{font-size:28px!important}.qr-print{break-inside:avoid}

        }
    </style>
    @endpush

    <div class="attendance-page space-y-6">
        <header class="no-print flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-warna-200 mb-2">Member / Absensi</p>
                <h1 class="text-2xl sm:text-3xl font-bold flex items-center gap-3"><i class="fa-solid fa-qrcode text-warna-400" aria-hidden="true"></i>QR Absensi</h1>
                <p class="text-sm text-warna-200 mt-2">{{ now()->locale('id')->translatedFormat('l, d F Y') }} · WITA</p>
            </div>
            <span class="inline-flex items-center gap-2 rounded-full border border-warna-700/20 bg-warna-700/10 px-4 py-2 text-sm font-medium text-warna-700"><span class="h-2 w-2 rounded-full bg-warna-700"></span>QR statis · Tanpa kedaluwarsa</span>
        </header>

        @if(session('status'))
            <div class="no-print rounded-xl border border-warna-700/20 bg-warna-700/10 p-4 text-sm" role="status"><i class="fa-solid fa-circle-check text-warna-700 mr-2" aria-hidden="true"></i>{{ session('status') }}</div>
        @endif

        <div class="no-print grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach([
                ['fa-qrcode', 'Kode tetap', 'Tidak berubah saat dimuat ulang'],
                ['fa-print', 'Siap dicetak', 'SVG tajam untuk layar dan kertas'],
                ['fa-shield-halved', 'Dikelola admin', 'Ganti kode hanya saat diperlukan'],
            ] as [$icon, $title, $description])
                <div class="qr-panel p-5 flex items-center gap-4">
                    <div class="h-12 w-12 shrink-0 rounded-2xl bg-warna-400/10 text-warna-400 flex items-center justify-center text-xl"><i class="fa-solid {{ $icon }}" aria-hidden="true"></i></div>
                    <div><h2 class="font-semibold text-sm">{{ $title }}</h2><p class="text-xs text-warna-200 mt-1 leading-relaxed">{{ $description }}</p></div>
                </div>
            @endforeach
        </div>

        <div class="attendance-grid grid grid-cols-1 xl:grid-cols-[minmax(0,1fr)_340px] gap-6 items-start">
            <section class="qr-panel qr-print p-5 sm:p-7">
                <div class="no-print flex items-center justify-between gap-3 border-b border-gray-100 pb-5 mb-6">
                    <div><h2 class="font-semibold text-lg">QR untuk member</h2><p class="text-xs text-warna-200 mt-1">Tampilkan di meja kasir atau cetak untuk area gym.</p></div>
                    <span class="rounded-lg bg-warna-50 px-3 py-1.5 text-xs font-medium text-warna-200">GYMYANKARTA</span>
                </div>
                <div class="text-center">
                    <p class="text-xs font-semibold tracking-widest text-warna-400 uppercase">GYMYANKARTA</p>
                    <h2 class="print-title text-2xl font-bold mt-2">Scan di sini, mulai latihan.</h2>
                    <p class="text-sm text-warna-200 mt-2">Buka dashboard member dan pilih <strong>Scan QR</strong>.</p>
                    <div class="mt-4 min-h-40">
                        <img id="attendance-qr" class="qr-image" src="{{ route('qr.generate') }}" alt="QR absensi GYMYANKARTA" width="1000" height="1000">
                        <div id="qr-error" class="no-print rounded-xl bg-red-50 p-8 text-sm text-red-700" role="alert" hidden>
                            <p class="mb-4">QR gagal dimuat. Periksa koneksi lalu coba lagi.</p>
                            <button class="qr-button" type="button" onclick="location.reload()">Coba lagi</button>
                        </div>
                    </div>
                    <p id="qr-loading" class="no-print text-sm text-warna-200 py-4" role="status">Memuat QR absensi…</p>
                    <p class="text-xs text-warna-200 leading-relaxed mt-2">Arahkan kamera ke seluruh kode dan tahan sebentar.<br>Gunakan akun member aktif untuk mencatat kehadiran.</p>
                </div>
                <div class="no-print flex flex-wrap justify-center gap-3 border-t border-gray-100 mt-6 pt-5">
                    <button id="download" class="qr-button qr-primary w-full sm:w-auto" disabled type="button"><i class="fa-solid fa-download" aria-hidden="true"></i>Unduh QR (SVG)</button>
                    <button id="print" class="qr-button w-full sm:w-auto" disabled type="button" onclick="window.print()"><i class="fa-solid fa-print" aria-hidden="true"></i>Cetak QR</button>
                </div>
            </section>

            <div class="no-print space-y-5">
                <section class="qr-panel p-6">
                    <h2 class="font-semibold flex items-center gap-2"><i class="fa-regular fa-circle-question text-warna-400" aria-hidden="true"></i>Cara member melakukan absen</h2>
                    <ol class="mt-6 space-y-5">
                        @foreach([
                            ['Buka dashboard member', 'Masuk dengan akun member, lalu pilih tombol Scan QR.'],
                            ['Arahkan kamera', 'Scan kode dari layar ini atau cetakan yang tersedia di gym.'],
                            ['Tunggu konfirmasi', 'Absensi berhasil akan muncul dan kehadiran langsung tercatat.'],
                        ] as [$title, $description])
                            <li class="flex gap-3"><span class="h-7 w-7 shrink-0 rounded-full bg-warna-400/10 text-warna-400 text-xs font-semibold flex items-center justify-center">{{ $loop->iteration }}</span><div><h3 class="text-sm font-semibold">{{ $title }}</h3><p class="text-xs text-warna-200 leading-relaxed mt-1">{{ $description }}</p></div></li>
                        @endforeach
                    </ol>
                </section>
                <section class="qr-panel p-6">
                    <h2 class="font-semibold flex items-center gap-2"><i class="fa-solid fa-sliders text-warna-400" aria-hidden="true"></i>Kelola kode QR</h2>
                    <p class="text-sm text-warna-200 leading-relaxed mt-3">Cetakan hilang atau rusak? Cukup unduh dan cetak ulang kode yang sama.</p>
                    <button class="qr-button w-full mt-4" type="button" onclick="location.reload()"><i class="fa-solid fa-rotate-right" aria-hidden="true"></i>Muat ulang tampilan</button>
                    <p class="text-xs text-warna-200 mt-2 text-center">Kode QR tetap sama.</p>
                    <div class="border-t border-gray-100 mt-5 pt-5">
                        <h3 class="text-sm font-semibold">Perlu mengganti kode?</h3>
                        <p class="text-xs text-warna-200 leading-relaxed mt-2 mb-4">QR baru akan menonaktifkan seluruh kode lama. Pastikan cetakan di area gym ikut diganti.</p>
                        <form method="POST" action="{{ route('qr.rotate') }}" onsubmit="return confirm('Ganti QR absensi? Semua QR dan cetakan lama tidak dapat digunakan lagi.');">
                            @csrf
                            <button class="qr-button w-full" type="submit"><i class="fa-solid fa-arrows-rotate text-warna-400" aria-hidden="true"></i>Buat QR baru</button>
                        </form>
                    </div>
                </section>
                <div class="rounded-2xl bg-warna-400/10 p-5 flex gap-3">
                    <i class="fa-regular fa-lightbulb text-warna-400 mt-1" aria-hidden="true"></i>
                    <p class="text-xs leading-relaxed text-warna-300">Letakkan cetakan di tempat terang dan rata. Hindari pantulan cahaya agar QR mudah dibaca kamera HP.</p>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        (() => {
            const qr = document.getElementById('attendance-qr');
            function ready() {
                const valid = qr.naturalWidth > 0;
                document.getElementById('qr-loading').hidden = true;
                document.getElementById('qr-error').hidden = valid;
                qr.hidden = !valid;
                document.getElementById('download').disabled = !valid;
                document.getElementById('print').disabled = !valid;
            }
            qr.addEventListener('load', ready);
            qr.addEventListener('error', ready);
            if (qr.complete) ready();
            document.getElementById('download').addEventListener('click', () => {
                window.location.href = @json(route('qr.generate', ['download' => 1]));
            });
        })();
    </script>
    @endpush
</x-layouts.dashboard>
