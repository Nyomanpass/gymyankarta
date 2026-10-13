@props(['member' => false])
@php
    $groups = $member ? [
        'AREA MEMBER' => [
            ['dashboard.member', 'fa-house', 'Dashboard Saya'],
        ],
    ] : [
        'MENU UTAMA' => [
            ['dashboard', 'fa-chart-pie', 'Dashboard'],
            ['kelola.pendapatan', 'fa-cash-register', 'Kasir & Transaksi'],
            ['kelola.member', 'fa-users', 'Kelola Member'],
            ['qr.attendance', 'fa-qrcode', 'QR Absensi'],
        ],
        'LAPORAN' => [
            ['laporan.member', 'fa-address-card', 'Laporan Member'],
            ['laporan.pendapatan', 'fa-chart-line', 'Laporan Pendapatan'],
        ],
        'PENGATURAN' => [
            ['pengaturan.harga', 'fa-sliders', 'Pengaturan Harga'],
            ['reset.password', 'fa-key', 'Keamanan Akun'],
        ],
    ];
@endphp
<div class="workspace-brand">
    <a href="{{ route($member ? 'dashboard.member' : 'dashboard') }}" class="flex items-center gap-3 min-w-0">
        <span class="brand-mark"><img src="{{ asset('logo.png') }}" alt="" width="36" height="36"></span>
        <span><strong>GYMYANKARTA</strong><small>{{ $member ? 'Member workspace' : 'Admin workspace' }}</small></span>
    </a>
    <button type="button" class="lg:hidden p-2 text-white/70" @click="sidebarOpen = false" aria-label="Tutup menu"><i class="fa-solid fa-xmark"></i></button>
</div>
<nav class="workspace-navigation" aria-label="Navigasi {{ $member ? 'member' : 'admin' }}">
    @foreach($groups as $label => $items)
        <div class="nav-group">
            <p class="nav-label">{{ $label }}</p>
            @foreach($items as [$route, $icon, $name])
                <a href="{{ route($route) }}" @click="sidebarOpen = false" class="workspace-link {{ request()->routeIs($route) ? 'is-active' : '' }}" @if(request()->routeIs($route)) aria-current="page" @endif>
                    <i class="fa-solid {{ $icon }}" aria-hidden="true"></i><span>{{ $name }}</span>
                </a>
            @endforeach
        </div>
    @endforeach
    @if($member)
        <div class="member-sidebar-note"><i class="fa-solid fa-dumbbell text-warna-400" aria-hidden="true"></i><p>Setiap latihan berarti.</p><small>Pantau membership dan kehadiranmu dari dashboard.</small></div>
    @endif
</nav>
<div class="workspace-sidebar-footer">
    <div class="sidebar-account"><span class="account-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span><div class="min-w-0"><p class="truncate">{{ Auth::user()->name }}</p><small>{{ $member ? 'Member' : 'Administrator' }}</small></div></div>
    <button type="button" @click="showLogoutModal = true; sidebarOpen = false" class="workspace-link w-full"><i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>Keluar</button>
</div>
