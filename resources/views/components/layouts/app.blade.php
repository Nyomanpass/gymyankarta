<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GYMTANKARTA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
</head>
<body class="bg-gray-100 font-poppins text-warna-300 overflow-x-hidden">
    <div class="min-h-screen bg-gray-100">
        <nav class="fixed top-0 left-0 right-0 z-40 h-16 bg-warna-50 boreder-b border-warna-100 shadow-sm">
            <div class="h-16 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center flex-shrink-0">
                        <img src="/logo.png" alt="Logo" class="h-10 w-10 mr-3">
                        <a href="{{ route('dashboard') }}" class="hidden md:block text-xl font-bold text-warna-300 hover:text-warna-400 transition-colors">
                            GYMYANKARTA
                        </a>    
                    </div>
                    
                    
                    
                    <!-- Alpine.js data -->
                    <div x-data="{ sidebarOpen: false }" class="lg:hidden">
                        <!-- Avatar button -->
                        <i @click="sidebarOpen = true" class=" mr-4 fa-solid fa-circle-user text-4xl cursor-pointer text-warna-300 active:scale-95 transition-all hover:text-warna-400"></i>
                        
                        <!-- Right Sidebar Overlay -->
                        <div x-show="sidebarOpen" 
                            x-cloak
                            x-transition:enter="transition-opacity ease-linear duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition-opacity ease-linear duration-300"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            @click="sidebarOpen = false"
                            class="fixed inset-0 z-50 bg-warna-300/50">
                        </div>
                        
                        <!-- Right Sidebar -->
                        <div x-show="sidebarOpen"
                            x-cloak
                            x-transition:enter="transition ease-in-out duration-300 transform"
                            x-transition:enter-start="translate-x-full"
                            x-transition:enter-end="translate-x-0"
                            x-transition:leave="transition ease-in-out duration-300 transform"
                            x-transition:leave-start="translate-x-0"
                            x-transition:leave-end="translate-x-full"
                            class="fixed top-0 right-0 z-50 h-full w-full md:w-1/2 bg-white shadow-lg">
                            
                            <!-- Close button -->
                            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                                <div class="flex items-center justify-center space-x-3">
                                    <button @click="sidebarOpen = false" class="flex items-center justify-center text-warna-300 hover:text-gray-600">
                                        <i class="fa-solid fa-angle-left text-xl "></i>
                                    </button>
                                    <h3 class="text-lg font-semibold text-warna-300">User Profile</h3>
                                </div>
                                <a href="{{ route('logout') }}" class="bg-warna-900 py-2 px-3 rounded-xl hover:bg-warna-900/80 transition-all active:scale-95"
                                        @click="sidebarOpen = false">
                                    <i class="fa-solid fa-right-from-bracket text-sm text-white"></i>
                                </a>
                            </div>
                        
                            <!-- Menu items -->
                            <div class="overflow-y-auto h-full">
                                <div class="mb-14 bg-white shadow-md rounded-lg px-6 py-10 w-full flex flex-col items-center ">
                                    
                                    <div class="w-28 h-28 rounded-full bg-warna-400 font-semibold text-white flex items-center justify-center">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                    <p class="text-2xl font-bold mt-6 text-center">{{ Auth::user()->name }}</p>
                                    <div class="bg-warna-700/30 text-warna-700 px-2 py-1 rounded-full text-sm mt-4">{{ Auth::user()->role }}</div>
                                    <div class="w-full mt-10 space-y-6">
                                        <x-g-input 
                                        label="Nama Lengkap"
                                        type="text"
                                        value="{{ Auth::user()->name }}"
                                        disabled
                                        class=" w-full disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed"
                                        />
                                        <x-g-input 
                                        label="Username"
                                        type="text"
                                        value="{{ Auth::user()->username }}"
                                        disabled
                                        class=" w-full disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed"
                                        />
                                        <x-g-input 
                                        label="Email"
                                        type="email"
                                        value="{{ Auth::user()->email }}"
                                        disabled
                                        class=" w-full disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed"
                                        />
                                        <x-g-input
                                        label="No. Telepon"
                                        type="text"
                                        value="{{ Auth::user()->phone }}"
                                        disabled
                                        class=" w-full disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed"
                                        />
                                    </div>
                                    <button wire:click="" class="mt-10 w-full bg-warna-400 hover:bg-warna-400/80 text-white font-semibold py-2 px-4 rounded-lg transition-all active:scale-95">
                                        Edit Profil
                                    </button>
                                    <button wire:click="" class="mt-5 w-full bg-white border border-warna-400 hover:bg-warna-400 text-warna-400 hover:text-white font-semibold py-2 px-4 rounded-lg transition-all active:scale-95">
                                        Ganti Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--dropdown button-->
                    <div x-data="{ dropdownOpen: false }" class="relative hidden lg:block">
                        <i @click="dropdownOpen = !dropdownOpen" class="mr-4 fa-solid fa-ellipsis-vertical text-2xl cursor-pointer text-warna-300 active:scale-95 transition-all hover:text-warna-400"></i>

                        <!-- Dropdown menu -->
                        <div x-show="dropdownOpen"
                             x-cloak
                             @click.outside="dropdownOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 z-10 bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <div class="px-4 py-3 text-xs text-gray-900 dark:text-white">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="text-warna-200/80">{{ Auth::user()->email }}</div>
                            </div>
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                                </li>
                            </ul>
                            <div class="py-1">
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Log out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="pt-16 px-4 sm:px-6 lg:px-8">
            <div class="">
                {{ $slot }}
            </div>
        </main>
    </div>
    @livewireScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>
</html>