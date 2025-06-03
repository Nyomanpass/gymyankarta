<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Dashboard GYMYANKARTA</title>
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      @livewireStyles
      <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-roboto text-warna-300 " x-data="{ sidebarOpen: false }">
      <div class="min-h-screen bg-gray-100">
            <!-- Navigation -->
            <nav class="fixed top-0 left-0 right-0 z-40 h-16 bg-warna-50 border-b border-warna-100 shadow-sm">
                  <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between h-16">
                              <!-- Logo -->
                              <div class="hidden lg:flex items-center">
                                    <img src="/logo.png" alt="Logo" class="h-10 w-10 mr-3">
                                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-warna-300 hover:text-warna-400 transition-colors">
                                          GYMYANKARTA
                                    </a>    
                              </div>
                              <!-- Button Sidebar -->
                              <div class="flex lg:hidden">
                                    <button 
                                          @click="sidebarOpen = !sidebarOpen" 
                                          class="text-warna-300 hover:text-warna-400 focus:outline-none focus:text-warna-400 text-xl px-3 py-1 rounded-lg border border-warna-100 " 
                                          aria-label="Toggle Sidebar">
                                          <i class="fa-solid fa-bars"></i>
                                    </button>
                              </div>
                              <!-- User Info -->
                              <div class="flex items-center">
                                    <p class="font-medium text-warna-300">Halo, {{ Auth::user()->name }}</p>
                              </div>
                        </div>
                  </div>
            </nav>

            <!-- Main Layout -->
            <div class="flex pt-16">
                  <!-- Sidebar -->
                  <aside class="hidden lg:block fixed left-0 top-16 h-[calc(100vh-4rem)] w-64 bg-warna-300 shadow-lg overflow-y-auto">
                        <div class="p-4 mt-3">
                              <nav class="space-y-3">
                                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-warna-400' : '' }}">
                                          <i class="fa-solid fa-house mr-3"></i>
                                          <span>Dashboard</span>
                                    </a>
                                    
                                    <a href="{{ route('kelola.pendapatan') }}" class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors {{ request()->routeIs('kelola.pendapatan') ? 'bg-warna-400' : '' }}">
                                          <i class="fa-solid fa-money-bill-trend-up mr-3"></i>
                                          <span>Kasir</span>
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors">
                                          <i class="fa-solid fa-user mr-3"></i>
                                          <span>Kelola Member</span>
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors">
                                          <i class="fa-solid fa-gear mr-3"></i>
                                          <span>Settings</span>
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors">
                                          <i class="fa-solid fa-right-from-bracket mr-3"></i>
                                          <span>Logout</span>
                                    </a>
                                    <!-- Add more navigation items here -->
                              </nav>
                        </div>
                  </aside>

                  <!-- Main Content -->
                  <main class="flex-1 lg:ml-64">
                        <div class="p-6 bg-gray-100 min-h-[calc(100vh-4rem)]">
                              {{ $slot }}
                        </div>
                  </main>
            </div>

            <!-- Mobile Sidebar Toggle (alter1) -->
            {{-- <div class="md:hidden fixed top-1/2 transform -translate-y-1/2 left-2 z-50 h-[95dvh] bg-warna-300 rounded-lg flex flex-col items-center py-10 px-4 shadow-lg text-white ">
                  <i class="fa-solid fa-bars text-2xl mb-15"></i>
                  <i class="fa-solid fa-house text-2xl mb-12"></i>
                  <i class="fa-solid fa-user text-2xl mb-12"></i>
                  <i class="fa-solid fa-money-bill-trend-up text-2xl mb-12"></i>
                  <i class="fa-solid fa-gear text-2xl mb-12"></i>
                  <i class="fa-solid fa-right-from-bracket text-2xl mb-12"></i>
            </div> --}}

            <!-- -- Mobile Sidebar Toggle (alter2) -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="lg:hidden fixed inset-0 bg-warna-300/50 bg-opacity-50 z-[48]">
            </div>

            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-in-out duration-200 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="lg:hidden fixed top-0 left-0 z-50 h-full w-64 bg-warna-300 shadow-lg transform">
                  
                  <!-- Mobile Sidebar Header -->
                  <div class="flex items-center justify-between px-4 py-6 border-b border-warna-100 mb-3">
                        <div class="flex items-center">
                              <img src="/logo.png" alt="Logo" class="h-8 w-8 mr-2">
                              <span class="text-white font-bold">GYMYANKARTA</span>
                        </div>
                        <button @click="sidebarOpen = false" class="text-white hover:text-gray-300">
                              <i class="fa-solid fa-times text-xl"></i>
                        </button>
                  </div>

                  <!-- Mobile Sidebar Navigation -->
                  <nav class="p-4 space-y-3">
                        <a href="{{ route('dashboard') }}" 
                           @click="sidebarOpen = false"
                           class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors">
                              <i class="fa-solid fa-house mr-3"></i>
                              <span>Dashboard</span>
                        </a>
                        <a href="#" 
                           @click="sidebarOpen = false"
                           class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors">
                              <i class="fa-solid fa-user mr-3"></i>
                              <span>Profile</span>
                        </a>
                        <a href="#" 
                           @click="sidebarOpen = false"
                           class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors">
                              <i class="fa-solid fa-money-bill-trend-up mr-3"></i>
                              <span>Membership</span>
                        </a>
                        <a href="#" 
                           @click="sidebarOpen = false"
                           class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-colors">
                              <i class="fa-solid fa-gear mr-3"></i>
                              <span>Settings</span>
                        </a>
                        <a href="#" 
                           @click="sidebarOpen = false"
                           class="flex items-center px-4 py-3 text-white hover:bg-warna-400 rounded-lg transition-colors">
                              <i class="fa-solid fa-right-from-bracket mr-3"></i>
                              <span>Logout</span>
                        </a>
                  </nav>
            </div>
      </div>



      <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
      @livewireScripts
</body>
</html>