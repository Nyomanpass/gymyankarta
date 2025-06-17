<!-- filepath: c:\laragon\www\gymyankarta\resources\views\components\layouts\dashboard.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard GYMYANKARTA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] { 
            display: none !important; 
        }
        
        /* Hapus debug border ini */
        /* * {
            border: orangered 1px solid !important;
        } */
        
        /* Prevent horizontal scroll */
        html, body {
            overflow-x: hidden;
        }
        
        /* Ensure proper box sizing */
        *, *::before, *::after {
            box-sizing: border-box;
        }
    </style>
</head>
<body class="bg-gray-100 font-poppins text-warna-300 overflow-x-hidden" x-data="{ sidebarOpen: false, showLogoutModal: false }" x-init="showLogoutModal = false">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-40 h-16 bg-warna-50 border-b border-warna-100 shadow-sm">
            <div class="h-16 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <div class="hidden lg:flex items-center flex-shrink-0">
                        <img src="/logo.png" alt="Logo" class="h-10 w-10 mr-3">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-warna-300 hover:text-warna-400 transition-colors">
                            GYMYANKARTA
                        </a>    
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <div class="flex lg:hidden">
                        <button 
                            @click="sidebarOpen = !sidebarOpen" 
                            class="text-warna-300 hover:text-warna-400 focus:outline-none focus:text-warna-400 text-xl px-3 py-1 rounded-lg border border-warna-100" 
                            aria-label="Toggle Sidebar">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                    </div>
                    
                    <!-- User Info -->
                    <div class="flex items-center flex-shrink-0">
                        <p class="font-medium text-warna-300 truncate">Halo, {{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Layout -->
        <div class="flex pt-16">
            <!-- Desktop Sidebar -->
            <aside class="hidden lg:block fixed left-0 top-16 h-[calc(100vh-4rem)] w-60 xl:w-72 bg-warna-300 shadow-lg overflow-y-auto z-30 flex-shrink-0">
                <div class="p-4 mt-3">
                    <nav class="space-y-3">
                        <!-- Main Navigation -->
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-warna-400' : '' }}">
                            <i class="fa-solid fa-house mr-3 flex-shrink-0"></i>
                            <span class="truncate">Dashboard</span>
                        </a>
                        
                        <a href="{{ route('kelola.pendapatan') }}" class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('kelola.pendapatan') ? 'bg-warna-400' : '' }}">
                            <i class="fa-solid fa-money-bill-trend-up mr-3 flex-shrink-0"></i>
                            <span class="truncate">Kasir</span>
                        </a>
                        
                        <a href="{{ route('kelola.member') }}" class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('kelola.member') ? 'bg-warna-400' : '' }}">
                            <i class="fa-solid fa-user mr-3 flex-shrink-0"></i>
                            <span class="truncate">Kelola Member</span>
                        </a>

                        <!-- Divider -->
                        <div class="border-t border-warna-200 my-4"></div>
                        
                        <!-- Tools Section -->
                        <a target="_blank" href="{{ route('qr.attendance') }}" class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('qr.generate') ? 'bg-warna-400' : '' }}">
                            <i class="fa-solid fa-qrcode mr-3 flex-shrink-0"></i>
                            <span class="truncate">QR Absen</span>
                        </a>
                        
                        <a href="{{ route('pengaturan.harga') }}" class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('pengaturan.harga') ? 'bg-warna-400' : '' }}">
                            <i class="fa-solid fa-gear mr-3 flex-shrink-0"></i>
                            <span class="truncate">Pengaturan Harga</span>
                        </a>
                        
                        @php
                            $isLaporanActive = request()->routeIs('laporan.member') || request()->routeIs('laporan.pendapatan');
                        @endphp

                        <div class="relative" x-data="{ dropdownOpen: {{ $isLaporanActive ? 'true' : 'false' }} }">
                            <button @click="dropdownOpen = !dropdownOpen" 
                                    class="flex items-center w-full px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors">
                                <i class="fa-solid fa-chart-line mr-3 flex-shrink-0"></i>
                                <span class="truncate">Laporan</span>
                                <i class="fa-solid fa-chevron-down ml-auto transition-transform flex-shrink-0" 
                                :class="{ 'rotate-180': dropdownOpen }"></i>
                            </button>
                            
                            <div x-show="dropdownOpen" 
                                x-cloak
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                class="ml-6 mt-2 space-y-2">

                                <a href="{{ route('laporan.member') }}" 
                                class="flex items-center px-4 py-2 text-white hover:bg-warna-400 rounded-lg transition-colors text-sm {{ request()->routeIs('laporan.member') ? 'bg-warna-400' : '' }}">
                                    <i class="fa-solid fa-users mr-3 flex-shrink-0"></i>
                                    <span class="truncate">Laporan Member</span>
                                </a>

                                <a href="{{ route('laporan.pendapatan') }}" 
                                class="flex items-center px-4 py-2 text-white hover:bg-warna-400 rounded-lg transition-colors text-sm {{ request()->routeIs('laporan.pendapatan') ? 'bg-warna-400' : '' }}">
                                    <i class="fa-solid fa-dollar-sign mr-3 flex-shrink-0"></i>
                                    <span class="truncate">Laporan Pendapatan</span>
                                </a>

                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-warna-200 my-4"></div>

                        <!-- Account Section -->
                        <a href="{{ route('reset.password') }}"
                            class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('reset.password') ? 'bg-warna-400' : '' }}">
                            <i class="fa-solid fa-key mr-3 flex-shrink-0"></i>
                            <span class="truncate">Reset Password</span>
                        </a>
                        
                        <a href="#" @click="showLogoutModal = true" class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors">
                            <i class="fa-solid fa-right-from-bracket mr-3 flex-shrink-0"></i>
                            <span class="truncate">Logout</span>
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 lg:ml-60 xl:ml-72 min-w-0">
                <div class="p-4 sm:p-6 min-h-[calc(100vh-4rem)]">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-cloak
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="lg:hidden fixed inset-0 bg-warna-300/50 z-40">
        </div>

        <!-- Mobile Sidebar -->
        <div x-show="sidebarOpen"
             x-cloak 
             x-transition:enter="transition ease-in-out duration-200 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="lg:hidden fixed top-0 left-0 z-50 h-full w-64 bg-warna-300 shadow-lg transform overflow-y-auto">
            
            <!-- Mobile Sidebar Header -->
            <div class="flex items-center justify-between px-4 py-6 border-b border-warna-100 mb-3">
                <div class="flex items-center min-w-0">
                    <img src="/logo.png" alt="Logo" class="h-8 w-8 mr-2 flex-shrink-0">
                    <span class="text-white font-bold truncate">GYMYANKARTA</span>
                </div>
                <button @click="sidebarOpen = false" class="text-white hover:text-gray-300 flex-shrink-0">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>

            <!-- Mobile Sidebar Navigation -->
            <nav class="p-4 space-y-3">
                <!-- Main Navigation -->
                <a href="{{ route('dashboard') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-warna-400' : '' }}">
                    <i class="fa-solid fa-house mr-3 flex-shrink-0"></i>
                    <span class="truncate">Dashboard</span>
                </a>
                
                <a href="{{ route('kelola.pendapatan') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('kelola.pendapatan') ? 'bg-warna-400' : '' }}">
                    <i class="fa-solid fa-money-bill-trend-up mr-3 flex-shrink-0"></i>
                    <span class="truncate">Kasir</span>
                </a>
                
                <a href="{{ route('kelola.member') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('kelola.member') ? 'bg-warna-400' : '' }}">
                    <i class="fa-solid fa-user mr-3 flex-shrink-0"></i>
                    <span class="truncate">Kelola Member</span>
                </a>

                <!-- Divider -->
                <div class="border-t border-warna-200 my-4"></div>
                
                <!-- Tools Section -->
                <a target="_blank" href="{{ route('qr.attendance') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('qr.generate') ? 'bg-warna-400' : '' }}">
                    <i class="fa-solid fa-qrcode mr-3 flex-shrink-0"></i>
                    <span class="truncate">QR Absen</span>
                </a>
                
                <a href="{{ route('pengaturan.harga') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('pengaturan.harga') ? 'bg-warna-400' : '' }}">
                    <i class="fa-solid fa-gear mr-3 flex-shrink-0"></i>
                    <span class="truncate">Pengaturan Harga</span>
                </a>

                @php
                    $isLaporanActive = request()->routeIs('laporan.member') || request()->routeIs('laporan.pendapatan');
                @endphp

                <div class="relative" x-data="{ dropdownOpen: {{ $isLaporanActive ? 'true' : 'false' }} }">
                    <button @click="dropdownOpen = !dropdownOpen" 
                            class="flex items-center w-full px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors">
                        <i class="fa-solid fa-chart-line mr-3 flex-shrink-0"></i>
                        <span class="truncate">Laporan</span>
                        <i class="fa-solid fa-chevron-down ml-auto transition-transform flex-shrink-0" 
                           :class="{ 'rotate-180': dropdownOpen }"></i>
                    </button>
                    
                    <div x-show="dropdownOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="ml-6 mt-2 space-y-2">
                        <a href="{{ route('laporan.member') }}" 
                           @click="sidebarOpen = false"
                           class="flex items-center px-4 py-2 text-white hover:bg-warna-400 rounded-lg transition-colors text-sm {{ request()->routeIs('laporan.member') ? 'bg-warna-400' : '' }}">
                            <i class="fa-solid fa-users mr-3 flex-shrink-0"></i>
                            <span class="truncate">Laporan Member</span>
                        </a>
                        <a href="{{ route('laporan.pendapatan') }}" 
                           @click="sidebarOpen = false"
                           class="flex items-center px-4 py-2 text-white hover:bg-warna-400 rounded-lg transition-colors text-sm {{ request()->routeIs('laporan.pendapatan') ? 'bg-warna-400' : '' }}">
                            <i class="fa-solid fa-dollar-sign mr-3 flex-shrink-0"></i>
                            <span class="truncate">Laporan Pendapatan</span>
                        </a>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-warna-200 my-4"></div>

                <!-- Account Section -->
                <a href="{{ route('reset.password') }}"
                   @click="sidebarOpen = false"
                   class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('reset.password') ? 'bg-warna-400' : '' }}">
                    <i class="fa-solid fa-key mr-3 flex-shrink-0"></i>
                    <span class="truncate">Reset Password</span>
                </a>

                <a href="#" @click="showLogoutModal = true; sidebarOpen = false" 
                   class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors">
                    <i class="fa-solid fa-right-from-bracket mr-3 flex-shrink-0"></i>
                    <span class="truncate">Logout</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Logout Modal -->
    <div x-show="showLogoutModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-warna-300/50 z-50 flex items-center justify-center p-4">
                        
        <div x-show="showLogoutModal"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             @click.away="showLogoutModal = false"
             class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm">
                                    
            <div class="text-center">
                <i class="fa-solid fa-exclamation-triangle text-warna-800 text-4xl mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Logout</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari sistem?</p>
                
                <div class="flex space-x-3">
                    <button @click="showLogoutModal = false" 
                            class="flex-1 px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                        Batal
                    </button>
                    <a href="{{ route('logout') }}" 
                       class="flex-1 px-4 py-2 text-white bg-warna-900 rounded-lg hover:bg-warna-900/80 transition-colors text-center">
                        Ya, Logout
                    </a>
                </div>
            </div>
        </div>
    </div>



    @livewireScripts
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    @stack('scripts')
</body>
</html>