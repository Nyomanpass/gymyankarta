@props(['member' => false])
@php
    $pages = [
        'dashboard' => ['Dashboard', 'Ringkasan aktivitas, member, dan pendapatan gym.', 'fa-chart-pie'],
        'kelola.pendapatan' => ['Kasir & Transaksi', 'Catat transaksi dan pantau pendapatan dalam satu tempat.', 'fa-cash-register'],
        'kelola.member' => ['Kelola Member', 'Kelola data, status membership, dan kehadiran member.', 'fa-users'],
        'qr.attendance' => ['QR Absensi', 'Satu kode untuk memudahkan kehadiran member.', 'fa-qrcode'],
        'laporan.member' => ['Laporan Member', 'Tinjau perkembangan dan aktivitas membership gym.', 'fa-address-card'],
        'laporan.pendapatan' => ['Laporan Pendapatan', 'Pantau pemasukan dan telusuri riwayat transaksi.', 'fa-chart-line'],
        'pengaturan.harga' => ['Pengaturan Harga', 'Atur tarif kunjungan dan paket membership gym.', 'fa-sliders'],
        'reset.password' => ['Keamanan Akun', 'Perbarui password untuk menjaga keamanan akun Anda.', 'fa-key'],
        'dashboard.member' => ['Dashboard Saya', 'Pantau membership dan catat setiap langkah latihanmu.', 'fa-house'],
    ];
    [$pageTitle, $pageDescription, $pageIcon] = $pages[request()->route()?->getName()] ?? ['Dashboard', 'Selamat datang di GYMYANKARTA.', 'fa-house'];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }} · GYMYANKARTA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="app-release" content="{{ app(\App\Services\ApplicationRelease::class)->version() }}">
    <meta name="app-release-url" content="{{ route('app.release') }}">
    @livewireStyles
    @stack('styles')
    @if($member)
        <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js" defer></script>
        <style>#qr-reader video{width:100%!important;height:100%!important;object-fit:cover;border-radius:12px}#qr-reader canvas{display:none!important}#qr-reader{position:relative;overflow:hidden}</style>
    @endif
</head>
<body class="workspace font-poppins text-warna-300" x-data="{ sidebarOpen: false, showLogoutModal: false, isDesktop: window.innerWidth >= 1024 }" @resize.window="isDesktop = window.innerWidth >= 1024" @keydown.escape.window="sidebarOpen = false; showLogoutModal = false">
    <a href="#main-content" class="workspace-skip">Langsung ke konten</a>
    <div class="workspace-shell">
        <div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false" class="workspace-backdrop lg:hidden no-print"></div>
        <aside class="workspace-sidebar no-print" :class="{ 'is-open': sidebarOpen }" :inert="!isDesktop && !sidebarOpen" aria-label="Menu utama">
            <x-dashboard-navigation :member="$member" />
        </aside>
        <div class="workspace-main dashboard-main">
            <header class="workspace-header no-print">
                <div class="flex items-center gap-3 min-w-0">
                    <button type="button" class="workspace-menu-button lg:hidden" @click="sidebarOpen = !sidebarOpen" :aria-expanded="sidebarOpen" aria-label="Buka menu navigasi"><i class="fa-solid fa-bars" aria-hidden="true"></i></button>
                    <div class="workspace-breadcrumb"><span>{{ $member ? 'Area Member' : 'Workspace' }}</span><i class="fa-solid fa-chevron-right" aria-hidden="true"></i><strong>{{ $pageTitle }}</strong></div>
                </div>
                <div class="flex items-center gap-3 shrink-0"><span class="header-date hidden xl:block">{{ now()->locale('id')->translatedFormat('d M Y') }} · WITA</span><span class="account-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span><div class="hidden sm:block leading-tight"><p class="text-sm font-semibold">{{ Auth::user()->name }}</p><p class="text-xs text-warna-200 mt-1">{{ $member ? 'Member' : 'Administrator' }}</p></div></div>
            </header>
            <main id="main-content" class="workspace-content" tabindex="-1">
                @unless(request()->routeIs('qr.attendance'))
                    <div class="workspace-page-heading no-print">
                        <div><p class="page-eyebrow">{{ $member ? 'SELAMAT DATANG KEMBALI' : 'GYMYANKARTA / ADMINISTRASI' }}</p><h1>{{ $pageTitle }}</h1><p>{{ $pageDescription }}</p></div>
                        <span class="workspace-date">{{ now()->locale('id')->translatedFormat('l, d M Y') }}</span>
                    </div>
                @endunless
                <div class="workspace-page">{{ $slot }}</div>
            </main>
        </div>
    </div>
    <div x-show="showLogoutModal" x-cloak x-transition.opacity class="fixed inset-0 bg-warna-300/60 z-50 flex items-center justify-center p-4 no-print" role="dialog" aria-modal="true" aria-labelledby="logout-title" @click.self="showLogoutModal = false">
        <div class="bg-white rounded-2xl shadow-xl p-7 w-full max-w-sm">
            <span class="flex items-center justify-center w-12 h-12 rounded-2xl bg-warna-400/10 text-warna-400 mb-5"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
            <h2 id="logout-title" class="text-xl font-bold">Keluar dari akun?</h2><p class="text-sm text-warna-200 mt-2 mb-6">Anda dapat masuk kembali kapan saja.</p>
            <div class="flex gap-3"><button type="button" @click="showLogoutModal = false" class="flex-1 px-4 py-3 border border-gray-200 rounded-xl">Batal</button><a href="{{ route('logout') }}" class="flex-1 px-4 py-3 text-white bg-warna-400 hover:bg-warna-500 rounded-xl text-center font-semibold">Ya, keluar</a></div>
        </div>
    </div>
    @livewireScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    @stack('scripts')
</body>
</html>
