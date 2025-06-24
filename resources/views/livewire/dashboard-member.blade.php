<div class="min-h-screen select-none">
    <!---mobile-->
    <div class="w-full max-w-lg mx-auto lg:hidden ">
        <div class="mb-8 flex items-center justify-start ">
            <div x-data="{ sidebarOpen: false }">
                <!-- Avatar Trigger -->
                <i @click="sidebarOpen = true" class="mr-4 fa-solid fa-circle-user text-4xl cursor-pointer text-warna-300 active:scale-95 transition-all hover:text-warna-400"></i>
                
                <!-- Overlay -->
                <div x-show="sidebarOpen" 
                     x-cloak
                     @click="sidebarOpen = false"
                     x-transition:enter="transition-opacity ease-linear duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-40 bg-warna-300/50">
                </div>
                
                <!-- Sidebar Panel -->
                <div x-show="sidebarOpen"
                     x-cloak
                     x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="fixed top-0 left-0 z-50 h-full w-full md:w-1/2 bg-white shadow-lg">
                    
                    <!-- Header -->
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <button @click="sidebarOpen = false" class="text-warna-300 hover:text-gray-600">
                                <i class="fa-solid fa-angle-left text-xl"></i>
                            </button>
                            <h3 class="text-lg font-semibold text-warna-300">User Profile</h3>
                        </div>
                    </div>
                
                    <!-- Content - AREA LIVEWIRE -->
                    <div class="overflow-y-auto h-full pb-20">
                        <div class="bg-white px-6 py-10 w-full flex flex-col items-center">
                            
                            <!-- Avatar -->
                            <div class="w-28 h-28 rounded-full bg-warna-400 font-semibold text-white flex items-center justify-center">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            
                            <!-- User Info -->
                            <p class="text-2xl font-bold mt-6 text-center">{{ Auth::user()->name }}</p>
                            <div class="bg-warna-700/30 text-warna-700 px-2 py-1 rounded-full text-sm mt-4">{{ Auth::user()->role }}</div>
                            
                            <!-- Profile Form - PURE LIVEWIRE AREA -->
                            <div class="w-full mt-10 space-y-6">
                                <x-g-input 
                                    label="Nama Lengkap"
                                    type="text"
                                    :disabled="!$isEditMode"
                                    value="{{ Auth::user()->name }}"
                                    wire:model.live="name"
                                    class="w-full disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed {{ $isEditMode ? 'border-warna-400 ring-2 ring-warna-400/20' : '' }}"
                                />
                                <x-g-input 
                                    label="Username"
                                    type="text"
                                    :disabled="!$isEditMode"
                                    value="{{ Auth::user()->username }}"
                                    wire:model.live="username"
                                    class="w-full disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed {{ $isEditMode ? 'border-warna-400 ring-2 ring-warna-400/20' : '' }}"
                                />
                                <x-g-input 
                                    label="Email"
                                    type="email"
                                    :disabled="!$isEditMode"
                                    value="{{ Auth::user()->email }}"
                                    wire:model.live="email"
                                    class="w-full disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed {{ $isEditMode ? 'border-warna-400 ring-2 ring-warna-400/20' : '' }}"
                                />
                                <x-g-input
                                    label="No. Telepon"
                                    type="text"
                                    :disabled="!$isEditMode"
                                    value="{{ Auth::user()->nomor_telepon }}"
                                    wire:model.live="nomor_telepon"
                                    class="w-full disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed {{ $isEditMode ? 'border-warna-400 ring-2 ring-warna-400/20' : '' }}"
                                />
                            </div>
                            
                            <!-- Action Buttons - PURE LIVEWIRE -->
                            <div class="w-full mt-6 space-y-3">
                                @if(!$isEditMode)
                                    <!-- Edit Button -->
                                    <button 
                                        wire:click="toggleEditMode"
                                        class="w-full bg-warna-400 hover:bg-warna-400/80 text-white font-semibold py-3 px-4 rounded-lg transition-all active:scale-95"
                                    >
                                        Edit Profil
                                    </button>
                                    
                                    <!-- Change Password Button -->
                                    <button 
                                        wire:click="toggleChangePasswordModal"
                                        class="w-full bg-white border border-warna-400 hover:bg-warna-400 text-warna-400 hover:text-white font-semibold py-3 px-4 rounded-lg transition-all active:scale-95"
                                    >
                                        Ganti Password
                                    </button>

                                    <a href="{{ route('logout') }}" class="mt-12 w-full text-warna-900 font-semibold py-3 px-4 rounded-lg transition-all active:scale-95 block text-center">
                                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                                    </a>
                                @else
                                    <!-- Save & Cancel Buttons -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <button 
                                            wire:click="toggleEditMode"
                                            class="border-2 border-warna-400 text-warna-400 hover:text-white hover:bg-warna-400 font-semibold py-3 px-4 rounded-lg transition-all active:scale-95"
                                        >
                                            Batal
                                        </button>
                                        <button 
                                            wire:click="updateProfile"
                                            wire:loading.attr="disabled"
                                            wire:target="updateProfile"
                                            class="bg-warna-400 hover:bg-warna-400/80 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold py-3 px-4 rounded-lg transition-all active:scale-95"
                                        >
                                            <span wire:loading.remove wire:target="updateProfile">Simpan</span>
                                            <span wire:loading wire:target="updateProfile">Menyimpan...</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium">Selamat Datang Kembali,</h3>
                <h1 class="text-xl font-bold text-warna-300">{{ Auth::user()->name }} 
                    <span class="text-xs font-medium rounded-full px-2 py-1 
                        {{ Auth::user()->status === 'active' ? 'bg-warna-500/30 text-warna-500' : 'bg-warna-900/20 text-warna-900' }}">
                        {{ Auth::user()->status }}
                    </span>
                </h1>
            </div>
        </div>
        <div class="mt-6 bg-white px-6 py-5 rounded-lg w-full shadow-md">
             <div class="flex w-full items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Absensi Hari Ini</h2>
                    <p class="text-sm text-warna-200/80">{{ now()->format('d F Y') }}</p>
                </div>
                <div class="w-14 h-14 {{ $isAttendedToday ? 'bg-warna-700' : 'bg-warna-900' }} rounded-lg flex items-center justify-center">
                    <i class="fas {{ $isAttendedToday ? 'fa-calendar-check' : 'fa-calendar-xmark' }} text-3xl text-warna-50"></i>
                </div>
            </div>
        </div>
        <div class="mt-6 w-full grid grid-cols-3 gap-3">
            <div class="bg-white px-3 py-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                <div class="w-8 h-8 bg-warna-700/30 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-check text-warna-700"></i>
                </div>
                <h3 class="text-xs font-medium text-gray-500 mb-1">Hadir</h3>
                <p class="text-xl font-bold text-gray-800">{{ $totalHadir }}</p>
            </div>
            <div class="bg-white px-3 py-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                <div class="w-8 h-8 bg-warna-900/30 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-times text-sm text-warna-900"></i>
                </div>
                <h3 class="text-xs font-medium text-gray-500 mb-1">Tidak Hadir</h3>
                <p class="text-xl font-bold text-gray-800">{{ $totalTidakHadir }}</p>
            </div>
            <div class="bg-white px-3 py-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                <div class="w-8 h-8 bg-warna-600/30 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-calendar text-sm text-warna-600"></i>
                </div>
                <h3 class="text-xs font-medium text-gray-500 mb-1">Masa Aktif</h3>
                <p class="text-xl font-bold text-gray-800">{{ $sisaHariAktif }}</p>
            </div>
        </div>

        <!--kalender riwayat absensi-->
        <div class="mt-6 bg-white px-4 py-5 rounded-lg w-full shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Riwayat Absensi</h3>
                <span class="text-sm text-warna-600 font-medium">{{ $persentaseKehadiran }}%</span>
            </div>
            
            <!-- Month/Year Selector -->
            <div class="flex gap-3 mb-4">
                <div class="flex-1">
                    <select wire:model.live="selectedMonth" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-warna-500 focus:border-transparent">
                        @foreach($monthOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <select wire:model.live="selectedYear" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-warna-500 focus:border-transparent">
                        @foreach($yearOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Header Hari -->
            <div class="grid grid-cols-7 gap-1 mb-2">
                @foreach(['S', 'S', 'R', 'K', 'J', 'S', 'M'] as $day)
                    <div class="text-center text-xs font-medium text-gray-500 py-1">{{ $day }}</div>
                @endforeach
            </div>

            <!-- Kalender Grid Mobile -->
            <div class="grid grid-cols-7 gap-1 mb-6">
                @foreach($calendarDays as $day)
                    <div class="relative h-10 flex items-center justify-center text-sm border border-gray-200 rounded
                        {{ !$day['isCurrentMonth'] ? 'bg-gray-50 text-gray-400' : 'bg-white' }}
                        {{ $day['isToday'] ? 'ring-2 ring-warna-500' : '' }}
                        {{ $day['isAttended'] ? 'bg-green-100' : '' }}
                        {{ $day['isMembershipActive'] && !$day['isAttended'] ? 'bg-blue-50 border-blue-200' : '' }}">
                        
                        <span class="
                            {{ $day['isAttended'] ? 'text-blue-400 font-semibold' : '' }}
                            {{ $day['isMembershipActive'] && !$day['isAttended'] ? 'text-blue-400' : '' }}
                            {{ !$day['isMembershipActive'] && $day['isCurrentMonth'] ? 'text-gray-700' : '' }}
                            {{ !$day['isCurrentMonth'] ? 'text-gray-400' : '' }}">
                            {{ $day['day'] }}
                        </span>
                        
                        @if($day['isAttended'])
                            <div class="absolute top-0 right-0 -mt-1 -mr-1">
                                <div class="w-4 h-4 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- keterangan kalendar Mobile -->
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="flex items-center gap-1.5">
                    <div class="w-3 h-3 bg-green-100 border border-green-200 rounded flex items-center justify-center">
                        <i class="fas fa-check text-green-600 text-xs"></i>
                    </div>
                    <span class="text-gray-600">Hadir</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-3 h-3 bg-blue-50 border border-blue-200 rounded flex items-center justify-center text-blue-400 text-xs font-semibold">
                        1
                    </div>
                    <span class="text-gray-600">Membership Aktif</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-3 h-3 bg-white border border-gray-200 rounded flex items-center justify-center text-gray-700 text-xs">
                        1
                    </div>
                    <span class="text-gray-600">Membership Tidak Aktif</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-3 h-3 bg-white border-2 border-warna-500 rounded"></div>
                    <span class="text-gray-600">Hari Ini</span>
                </div>
            </div>

        </div>

    </div>

    <!--floating button for absense-->
    <div class="fixed bottom-4 right-4 z-30 lg:hidden">
        <button wire:click="openQrScanner" 
                class="w-max h-max  shadow-lg transition-all px-4 py-3  font-semibold rounded-2xl flex items-center justify-center active:scale-95
                {{ $isAttendedToday || Auth::user()->status != 'active' ? 'border-2 border-gray-400 bg-gray-300 text-warna-300 cursor-not-allowed' : 'text-white bg-warna-400 hover:bg-warna-400/80' }}"
                @disabled($isAttendedToday || Auth::user()->status != 'active')>
            <i class="bi bi-qr-code-scan text-2xl mr-2"></i>
            <span class="text-sm">{{ $isAttendedToday ? 'Sudah Absen' : 'Absen' }}</span>
        </button>
    </div>

    <!--desktop-->
    <div class="hidden lg:block">
        <div class="max-w-7xl mx-auto px-4 py-10">
            <div class="flex items-start gap-5 h-max">
                <div class="bg-white shadow-md rounded-lg px-6 py-10 w-1/3 flex flex-col items-center h-full">
                    
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
                            :disabled="!$isEditMode"
                            wire:model.live="name"
                            class="w-full disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed {{ $isEditMode ? 'border-warna-400 ring-2 ring-warna-400/20' : '' }}"
                        />
                        <x-g-input 
                            label="Username"
                            type="text"
                            value="{{ Auth::user()->username }}"
                            :disabled="!$isEditMode"
                            wire:model.live="username"
                            class="w-full disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed {{ $isEditMode ? 'border-warna-400 ring-2 ring-warna-400/20' : '' }}"
                        />
                        <x-g-input 
                            label="Email"
                            type="email"
                            value="{{ Auth::user()->email }}"
                            :disabled="!$isEditMode"
                            wire:model.live="email"
                            class="w-full disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed {{ $isEditMode ? 'border-warna-400 ring-2 ring-warna-400/20' : '' }}"
                        />
                        <x-g-input
                            label="No. Telepon"
                            type="text"
                            value="{{ Auth::user()->phone }}"
                            :disabled="!$isEditMode"
                            wire:model.live="nomor_telepon"
                            class="w-full disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed {{ $isEditMode ? 'border-warna-400 ring-2 ring-warna-400/20' : '' }}"
                        />
                    </div>
                    <div class="w-full mt-10 flex gap-2">
                        <button wire:click="toggleEditMode" class="{{ $isEditMode ? 'w-1/2' : 'w-full' }}  font-semibold py-3 px-4 rounded-lg transition-all active:scale-95 {{ $isEditMode ? 'border-2 border-warna-400 text-warna-400 hover:text-white hover:bg-warna-400' : 'text-white bg-warna-400 hover:bg-warna-400/80' }}">
                            {{ $isEditMode ? 'Batal' : 'Edit Profile' }}
                        </button>
                        @if ($isEditMode)
                        <button wire:click="updateProfile" 
                            wire:loading.attr="disabled" 
                            wire:target="updateProfile"
                            class="w-1/2 bg-warna-400 hover:bg-warna-400/80 disabled:bg-warna-400/50 disabled:cursor-not-allowed text-white font-semibold py-3 px-4 rounded-lg transition-all active:scale-95 flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="updateProfile">Simpan</span>
                            <span wire:loading wire:target="updateProfile" class="flex items-center gap-2">
                                Menyimpan...
                            </span>
                        </button>
                        @endif
                    </div>
                    @if (!$isEditMode)
                        
                    <button wire:click="toggleChangePasswordModal" class="mt-5 w-full bg-white border border-warna-400 hover:bg-warna-400 text-warna-400 hover:text-white font-semibold py-2 px-4 rounded-lg transition-all active:scale-95">
                        Ganti Password
                    </button>
                    @endif
                </div>
                
                <div class="w-2/3 space-y-6">
                    <div class="w-full grid grid-cols-3 gap-6">
                        <div class="bg-gradient-to-br from-white to-gray-50 shadow-lg rounded-2xl p-6 border border-gray-100">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-warna-700/30 rounded-xl flex items-center justify-center shadow-md">
                                    <i class="fas fa-check text-xl text-warna-700"></i>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-extrabold text-gray-800">{{ $totalHadir }}</p>
                                    <span class="text-xs text-gray-500 bg-green-100 px-2 py-1 rounded-full">hari</span>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Total Hadir</h3>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <div class="bg-warna-700 h-2 rounded-full" style="width: {{ min(100, $persentaseKehadiran) }}%"></div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-white to-gray-50 shadow-lg rounded-2xl p-6 border border-gray-100">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-warna-900/30 rounded-xl flex items-center justify-center shadow-md">
                                    <i class="fas fa-times text-xl text-warna-900"></i>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-extrabold text-gray-800">{{ $totalTidakHadir }}</p>
                                    <span class="text-xs text-gray-500 bg-red-100 px-2 py-1 rounded-full">hari aktif</span>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Tidak Hadir</h3>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <!-- ✅ PERBAIKAN: Progress bar berdasarkan hari membership aktif -->
                                @php
                                    $absentPercentage = $attendanceStats['membershipActiveDays'] > 0 
                                        ? min(100, ($totalTidakHadir / $attendanceStats['membershipActiveDays']) * 100) 
                                        : 0;
                                @endphp
                                <div class="bg-warna-900 h-2 rounded-full transition-all duration-500" 
                                    style="width: {{ $absentPercentage }}%"></div>
                            </div>
                            <!-- ✅ TAMBAHKAN: Info tambahan -->
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>{{ $totalTidakHadir }} dari {{ $attendanceStats['membershipActiveDays'] ?? 0 }} hari aktif</span>
                                <span></span>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-white to-gray-50 shadow-lg rounded-2xl p-6 border border-gray-100">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-warna-600/30 rounded-xl flex items-center justify-center shadow-md">
                                    <i class="fas fa-calendar text-xl text-warna-600"></i>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-extrabold text-gray-800">{{ $sisaHariAktif }}</p>
                                    <span class="text-xs text-gray-500 bg-blue-100 px-2 py-1 rounded-full">hari tersisa</span>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Masa Aktif</h3>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <!-- ✅ PERBAIKAN: Progress bar decrease berdasarkan sisa hari -->
                                @php
                                    $progressPercentage = $totalMembershipDays > 0 
                                        ? min(100, max(0, ($sisaHariAktif / $totalMembershipDays) * 100)) 
                                        : 0;
                                @endphp
                                <div class="bg-warna-600 h-2 rounded-full transition-all duration-500" 
                                    style="width: {{ $progressPercentage }}%"></div>
                            </div>
                            <!-- ✅ TAMBAHKAN: Info tambahan -->
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>{{ $sisaHariAktif }} hari tersisa</span>
                                <span>{{ $totalMembershipDays }} hari total</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white shadow-md rounded-lg px-6 py-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 {{ $isAttendedToday ? 'bg-warna-700' : 'bg-warna-900' }} rounded-lg flex items-center justify-center shadow-md">
                                <i class="fas {{ $isAttendedToday ? 'fa-calendar-check' : 'fa-calendar-xmark' }} text-white text-3xl"></i>
                            </div>
                            <div>
                                
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Absensi Hari Ini
                                    
                                </h3>
                                <p class="text-sm text-gray-600">{{ now()->format('d F Y') }}</p>
                                
                            </div>
                        </div>
                        <div>
                            @if (Auth::user()->status != 'active')
                                <p class="text-xs text-gray-600 mb-1">Status Akun: {{ Auth::user()->status }}</p>
                            @endif
                            <button wire:click="openQrScanner" 
                                    class=" font-semibold py-2 px-4 rounded-lg transition-all active:scale-95 flex items-center justify-center gap-3
                                    {{ $isAttendedToday || Auth::user()->status != 'active' ? 'border-2 border-gray-400 bg-gray-300 text-warna-300 cursor-not-allowed' : 'text-white bg-warna-400 hover:bg-warna-400/80' }}"
                                    @disabled($isAttendedToday || Auth::user()->status != 'active')>
                                <i class="bi bi-qr-code-scan text-2xl"></i>
                                {{ $isAttendedToday ? 'Sudah Absen' : 'Scan QR Absen' }}
                            </button>
                        </div>
                        
                    </div>
                    
                    <!--kalender riwayat absensi-->
                    <div class="bg-white shadow-md rounded-lg px-6 py-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Riwayat Kehadiran</h3>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-warna-600">{{ $persentaseKehadiran }}%</div>
                                <div class="text-sm text-gray-600">Tingkat Kehadiran</div>
                            </div>
                        </div>

                        <!-- Month/Year Selector Desktop -->
                        <div class="flex gap-4 mb-6">
                            <div class="flex-1">
                                <select wire:model.live="selectedMonth" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-warna-500 focus:border-transparent">
                                    @foreach($monthOptions as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-1">
                                <select wire:model.live="selectedYear" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-warna-500 focus:border-transparent">
                                    @foreach($yearOptions as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Header Hari Desktop -->
                        <div class="grid grid-cols-7 gap-1 mb-2">
                            @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $day)
                                <div class="text-center text-sm font-medium text-gray-500 py-2">
                                    {{ $day }}
                                </div>
                            @endforeach
                        </div>

                        <!-- Kalender Grid Desktop -->
                        <div class="grid grid-cols-7 gap-1 mb-6">
                            @foreach($calendarDays as $day)
                                <div class="relative h-10 flex items-center justify-center text-sm border border-gray-200 rounded
                                    {{ !$day['isCurrentMonth'] ? 'bg-gray-50 text-gray-400' : 'bg-white' }}
                                    {{ $day['isToday'] ? 'ring-2 ring-warna-500' : '' }}
                                    {{ $day['isAttended'] ? 'bg-green-100' : '' }}
                                    {{ $day['isMembershipActive'] && !$day['isAttended'] ? 'bg-blue-50 border-blue-200' : '' }}">
                                    
                                    <span class="
                                        {{ $day['isAttended'] ? 'text-green-800 font-semibold' : '' }}
                                        {{ $day['isMembershipActive'] && !$day['isAttended'] ? 'text-blue-400' : '' }}
                                        {{ !$day['isMembershipActive'] && $day['isCurrentMonth'] ? 'text-gray-700' : '' }}
                                        {{ !$day['isCurrentMonth'] ? 'text-gray-400' : '' }}">
                                        {{ $day['day'] }}
                                    </span>
                                    
                                    @if($day['isAttended'])
                                        <div class="absolute top-0 right-0 -mt-1 -mr-1">
                                            <div class="w-4 h-4 bg-green-500 rounded-full flex items-center justify-center">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        

                        <!-- Keterangan Desktop -->
                        <div class="flex flex-wrap items-center gap-4 mb-4 text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-green-100 border border-green-200 rounded flex items-center justify-center">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="text-gray-600">Hadir</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-blue-50 border border-blue-200 rounded flex items-center justify-center text-blue-400 text-xs font-semibold">
                                    1
                                </div>
                                <span class="text-gray-600">Membership Aktif</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-white border border-gray-200 rounded flex items-center justify-center text-gray-700 text-xs">
                                    1
                                </div>
                                <span class="text-gray-600">Membership Tidak Aktif</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-white border-2 border-warna-500 rounded"></div>
                                <span class="text-gray-600">Hari Ini</span>
                            </div>
                        </div>

                        
                    </div>
                </div>

            </div>
        </div>
    </div>

@if($showQrScanner)
    <div x-data="{
        // State variables
        cameraGranted: false,
        hasError: false,
        errorMessage: '',
        isRequesting: false,
        showStatus: true,
        showSpinner: true,
        statusMessage: 'Memulai sistem...',
        isScanning: false,
        
        // ✅ TAMBAHAN: Camera management
        availableCameras: [],
        currentCameraId: null,
        currentFacingMode: 'environment', // 'environment' for back, 'user' for front
        isBackCamera: true,
        
        // QR Scanner instance
        html5QrCode: null,
        
        async init() {
            console.log('Initializing QR Scanner...');
            
            // Wait for dependencies
            await this.$nextTick();
            await this.waitForDependencies();
            
            // Check browser support
            if (!this.checkBrowserSupport()) {
                return;
            }
            
            // Load available cameras
            await this.loadAvailableCameras();
            
            // Auto request camera permission
            setTimeout(() => {
                this.requestCameraPermission();
            }, 500);
        },
        
        async waitForDependencies() {
            let attempts = 0;
            while (typeof Html5Qrcode === 'undefined' && attempts < 10) {
                console.log('Waiting for Html5Qrcode library...');
                await new Promise(resolve => setTimeout(resolve, 500));
                attempts++;
            }
            
            if (typeof Html5Qrcode === 'undefined') {
                this.setError('Gagal memuat library QR Scanner');
                return false;
            }
            
            console.log('Html5Qrcode library loaded');
            return true;
        },
        
        // ✅ TAMBAHAN: Load available cameras
        async loadAvailableCameras() {
            try {
                const cameras = await Html5Qrcode.getCameras();
                this.availableCameras = cameras || [];
                console.log('📱 Available cameras:', this.availableCameras);
            } catch (error) {
                console.log('Could not load cameras:', error);
                this.availableCameras = [];
            }
        },
        
        checkBrowserSupport() {
            const isHttps = location.protocol === 'https:' || 
                          location.hostname === 'localhost' || 
                          location.hostname === '127.0.0.1';
                          
            const hasMediaDevices = navigator.mediaDevices && navigator.mediaDevices.getUserMedia;
            
            if (!isHttps) {
                this.setError('Camera API memerlukan HTTPS atau localhost');
                return false;
            }
            
            if (!hasMediaDevices) {
                this.setError('Browser tidak mendukung Camera API');
                return false;
            }
            
            return true;
        },
        
        async requestCameraPermission() {
            console.log('Requesting camera permission...');
            
            this.isRequesting = true;
            this.hasError = false;
            this.setStatus('Meminta izin kamera...', true);
            
            try {
                // ✅ PERBAIKAN: Dynamic constraints based on current facing mode
                const constraints = {
                    video: {
                        facingMode: { exact: this.currentFacingMode },
                        width: { ideal: 1280, min: 640 },
                        height: { ideal: 720, min: 480 }
                    }
                };
                
                let stream;
                try {
                    stream = await navigator.mediaDevices.getUserMedia(constraints);
                    console.log('✅ Camera accessed with exact constraint');
                } catch (exactError) {
                    console.log('⚠️ Exact constraint failed, trying ideal...');
                    const fallbackConstraints = {
                        video: {
                            facingMode: { ideal: this.currentFacingMode },
                            width: { ideal: 640, min: 320 },
                            height: { ideal: 480, min: 240 }
                        }
                    };
                    stream = await navigator.mediaDevices.getUserMedia(fallbackConstraints);
                    console.log('✅ Camera accessed with ideal constraint');
                }
                
                console.log('Camera permission granted');
                console.log('Stream tracks:', stream.getTracks().map(t => ({ 
                    kind: t.kind, 
                    label: t.label,
                    settings: t.getSettings() 
                })));
                
                // Stop test stream
                stream.getTracks().forEach(track => {
                    console.log('Stopping track:', track.label);
                    track.stop();
                });
                
                // Update state
                this.cameraGranted = true;
                this.isRequesting = false;
                this.setStatus('Izin diberikan, memulai scanner...', true);
                
                // Start actual scanner with delay
                setTimeout(async () => {
                    await this.startQrScanner();
                }, 1000);
                
            } catch (error) {
                console.error('Camera permission error:', error);
                this.isRequesting = false;
                
                let errorMessage = 'Gagal mengakses kamera: ';
                
                switch(error.name) {
                    case 'NotAllowedError':
                        errorMessage += 'Akses ditolak. Silakan izinkan akses kamera di browser.';
                        break;
                    case 'NotFoundError':
                        errorMessage += 'Kamera tidak ditemukan di perangkat.';
                        break;
                    case 'NotSupportedError':
                        errorMessage += 'Browser tidak mendukung akses kamera.';
                        break;
                    case 'NotReadableError':
                        errorMessage += 'Kamera sedang digunakan aplikasi lain.';
                        break;
                    case 'OverconstrainedError':
                        errorMessage += 'Kamera tidak tersedia. Mencoba kamera alternatif...';
                        setTimeout(() => {
                            this.retryWithFlexibleConstraints();
                        }, 1000);
                        return;
                    default:
                        errorMessage += error.message || 'Error tidak diketahui.';
                }
                
                this.setError(errorMessage);
            }
        },
        
        async retryWithFlexibleConstraints() {
            try {
                this.setStatus('Mencari kamera yang tersedia...', true);
                
                const flexibleConstraints = {
                    video: {
                        facingMode: this.currentFacingMode,
                        width: { min: 320 },
                        height: { min: 240 }
                    }
                };
                
                const stream = await navigator.mediaDevices.getUserMedia(flexibleConstraints);
                console.log('✅ Camera accessed with flexible constraints');
                
                stream.getTracks().forEach(track => track.stop());
                
                this.cameraGranted = true;
                this.isRequesting = false;
                this.setStatus('Kamera ditemukan, memulai scanner...', true);
                
                setTimeout(async () => {
                    await this.startQrScanner();
                }, 1000);
                
            } catch (retryError) {
                console.error('Flexible constraint retry failed:', retryError);
                this.setError('Tidak dapat mengakses kamera yang sesuai.');
            }
        },
        
        async startQrScanner() {
            if (this.isScanning) {
              
                return;
            }
            
            try {
                this.isScanning = true;
                this.setStatus('Memulai kamera...', true);
                
                // Clear any existing scanner
                if (this.html5QrCode) {
                    try {
                        await this.html5QrCode.stop();
                        await this.html5QrCode.clear();
                    } catch (e) {
                        console.log('Old scanner cleanup:', e);
                    }
                }
                
                // Success callback
                const qrCodeSuccessCallback = (decodedText, decodedResult) => {
       
                    
                    this.stopScanner().then(() => {
                        this.setStatus('QR Code terdeteksi! Memproses...', true);
                        this.processQrAndRefresh(decodedText);
                    });
                };
                
                // Error callback
                const qrCodeErrorCallback = (errorMessage) => {
                    if (errorMessage.includes('NotFound') || errorMessage.includes('No QR code found')) {
                        return;
                    }
                   
                };
                
                // ✅ PERBAIKAN: Scanner config based on camera type
                const config = {
                    fps: 10,
                    qrbox: { width: 200, height: 200 },
                    aspectRatio: 1.0,
                    showTorchButtonIfSupported: true,
                    showZoomSliderIfSupported: false,
                    defaultZoomValueIfSupported: 1,
                    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
                    videoConstraints: {
                        facingMode: { exact: this.currentFacingMode }
                    }
                };
                
                // Initialize scanner
                this.html5QrCode = new Html5Qrcode('qr-reader');
                
                // ✅ PERBAIKAN: Select camera based on current facing mode
                let cameraId = await this.selectCamera();
                
                this.setStatus('Menghubungkan ke kamera...', true);
                
                // Start scanner
                await this.html5QrCode.start(
                    cameraId,
                    config,
                    qrCodeSuccessCallback,
                    qrCodeErrorCallback
                );
                
                // ✅ TAMBAHAN: Store current camera ID
                this.currentCameraId = cameraId;
                
                setTimeout(() => {
                    this.fixCameraMirror();
                    this.hideStatus();
                    
                }, 1000);
                
            } catch (error) {
              
                this.isScanning = false;
                
                let errorMessage = 'Gagal memulai scanner: ';
                
                if (error.toString().includes('NotAllowedError')) {
                    errorMessage += 'Akses kamera ditolak.';
                } else if (error.toString().includes('NotFoundError')) {
                    errorMessage += 'Kamera tidak ditemukan.';
                } else if (error.toString().includes('OverConstrainedError')) {
                    errorMessage += 'Kamera tidak mendukung pengaturan yang diminta.';
                } else if (error.toString().includes('NotReadableError')) {
                    errorMessage += 'Kamera sedang digunakan aplikasi lain.';
                } else {
                    errorMessage += error.message || 'Error tidak diketahui.';
                }
                
                this.setError(errorMessage);
                
                if (error.toString().includes('OverConstrainedError')) {
                    console.log('🔄 Retrying with basic constraints...');
                    setTimeout(() => {
                        this.retryWithBasicConfig();
                    }, 2000);
                }
            }
        },
        
        // ✅ TAMBAHAN: Switch camera function
        async switchCamera() {
            if (!this.isScanning || this.availableCameras.length < 2) {
                return;
            }
            
            try {
                this.setStatus('Beralih kamera...', true);
                
                // Toggle facing mode
                this.currentFacingMode = this.currentFacingMode === 'environment' ? 'user' : 'environment';
                this.isBackCamera = this.currentFacingMode === 'environment';
                
                console.log('🔄 Switching to:', this.currentFacingMode);
                
                // Stop current scanner
                await this.stopScanner();
                
                // Restart with new camera
                setTimeout(async () => {
                    await this.startQrScanner();
                }, 500);
                
            } catch (error) {
                console.error('Error switching camera:', error);
                this.setError('Gagal beralih kamera: ' + error.message);
            }
        },
        
        fixCameraMirror() {
            try {
                const videoElement = document.querySelector('#qr-reader video');
                if (videoElement) {
                    // ✅ PERBAIKAN: Apply mirror only for front camera
                    if (this.currentFacingMode === 'user') {
                        // Front camera - apply mirror
                        videoElement.style.transform = 'scaleX(-1)';
                        videoElement.style.webkitTransform = 'scaleX(-1)';
                        
                    } else {
                        // Back camera - no mirror
                        videoElement.style.transform = 'scaleX(1)';
                        videoElement.style.webkitTransform = 'scaleX(1)';
                        
                    }
                }
            } catch (error) {
                
            }
        },
        
        async processQrAndRefresh(qrData) {
            try {
                await @this.call('processQrScan', qrData);
                
                setTimeout(() => {
                    console.log('🔄 Refreshing page after successful scan...');
                    window.location.reload();
                }, 2000);
                
            } catch (error) {
                console.error('Error processing QR:', error);
                this.setError('Gagal memproses QR Code: ' + error.message);
            }
        },
        
        // ✅ PERBAIKAN: Select camera based on facing mode
        async selectCamera() {
            try {
                if (this.availableCameras.length === 0) {
                    
                    return { facingMode: { exact: this.currentFacingMode } };
                }
                
                const targetKeywords = this.currentFacingMode === 'environment' 
                    ? ['back', 'rear', 'environment', 'facing back', 'camera2', '0', 'main', 'wide']
                    : ['front', 'user', 'facing front', 'camera1', 'selfie'];
                
                let selectedCamera = null;
                
                // Find camera by label
                for (const camera of this.availableCameras) {
                    const label = camera.label.toLowerCase();
                    console.log('🔍 Checking camera:', camera.label);
                    
                    for (const keyword of targetKeywords) {
                        if (label.includes(keyword)) {
                            selectedCamera = camera;
                            
                            break;
                        }
                    }
                    if (selectedCamera) break;
                }
                
                // Find by ID if not found by label
                if (!selectedCamera) {
                    const cameraById = this.availableCameras.find(camera => {
                        const id = camera.id.toLowerCase();
                        if (this.currentFacingMode === 'environment') {
                            return id.includes('0') || id.includes('back') || id.includes('environment');
                        } else {
                            return id.includes('1') || id.includes('front') || id.includes('user');
                        }
                    });
                    
                    if (cameraById) {
                        selectedCamera = cameraById;
                        
                    }
                }
                
                // Use positional fallback
                if (!selectedCamera) {
                    if (this.currentFacingMode === 'environment' && this.availableCameras.length > 1) {
                        selectedCamera = this.availableCameras[this.availableCameras.length - 1];
                        
                    } else {
                        selectedCamera = this.availableCameras[0];
                        
                    }
                }
                
               
                return selectedCamera.id;
                
            } catch (err) {
               
                return { facingMode: { exact: this.currentFacingMode } };
            }
        },
        
        async retryWithBasicConfig() {
            try {
                this.setStatus('Mencoba pengaturan alternatif...', true);
                
                const basicConfig = {
                    fps: 5,
                    qrbox: 150,
                    aspectRatio: 1.0,
                    videoConstraints: {
                        facingMode: { exact: this.currentFacingMode }
                    }
                };
                
                let cameraConstraint = { facingMode: { exact: this.currentFacingMode } };
                
                await this.html5QrCode.start(
                    cameraConstraint,
                    basicConfig,
                    (decodedText) => {
                        
                        this.stopScanner().then(() => {
                            this.processQrAndRefresh(decodedText);
                        });
                    },
                    () => { /* silent */ }
                );
                
                setTimeout(() => {
                    this.fixCameraMirror();
                    this.hideStatus();
                    
                }, 1000);
                
            } catch (retryError) {
                
                this.setError('Gagal memulai scanner dengan pengaturan alternatif.');
            }
        },
        
        async stopScanner() {
            if (this.html5QrCode && this.isScanning) {
                try {
                    await this.html5QrCode.stop();
                    await this.html5QrCode.clear();
                    this.isScanning = false;
                    console.log('QR Scanner stopped');
                } catch (error) {
                    console.error('Error stopping scanner:', error);
                }
            }
        },
        
        closeScanner() {
            console.log('Closing scanner...');
            this.stopScanner();
            @this.call('closeQrScanner');
        },
        
        // Helper methods
        setStatus(message, showSpinner = true) {
            this.statusMessage = message;
            this.showSpinner = showSpinner;
            this.showStatus = true;
            this.hasError = false;
            console.log('📋 Status:', message);
        },
        
        hideStatus() {
            this.showStatus = false;
        },
        
        setError(message) {
            this.errorMessage = message;
            this.hasError = true;
            this.showStatus = false;
            this.isScanning = false;
            console.error('❌ Error:', message);
        },
        
        retryCamera() {
            this.hasError = false;
            this.cameraGranted = false;
            this.requestCameraPermission();
        }
    }" 
    x-init="init()"
    class="fixed inset-0 bg-warna-300/50 z-50 flex items-center justify-center p-4">
        
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Scan QR Code Absensi</h3>
                <div class="flex items-center space-x-2">
                    <!-- ✅ TAMBAHAN: Camera Switch Button -->
                    <button @click="switchCamera()" 
                            x-show="isScanning && availableCameras.length > 1"
                            class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors"
                            :title="isBackCamera ? 'Beralih ke Kamera Depan' : 'Beralih ke Kamera Belakang'">
                        <i class="fas fa-sync-alt text-lg"></i>
                    </button>
                    
                    <button @click="closeScanner()" class="text-gray-400 hover:text-gray-600 text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Scanner Container -->
            <div class="p-6">
                <div class="mb-4 text-center">
                    <p class="text-sm text-gray-600 mb-2">Arahkan kamera ke QR Code yang ada di meja kasir</p>
                    <div class="bg-blue-50 rounded-lg p-3 mb-4">
                        <p class="text-xs text-blue-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pastikan QR Code terlihat jelas di dalam frame
                        </p>
                    </div>
                </div>
                
                <!-- ✅ PERBAIKAN: QR Scanner Area dengan CSS fix untuk mirror -->
                <div class="relative bg-black rounded-lg overflow-hidden" style="height: 300px;">
                    <!-- Video akan muncul di sini -->
                    <div id="qr-reader" class="w-full h-full"></div>
                    
                    <!-- Scanner Overlay -->
                    <div x-show="!isScanning || showStatus" class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-48 h-48 border-2 border-white rounded-lg relative">
                            <!-- Corner indicators -->
                            <div class="absolute -top-1 -left-1 w-6 h-6 border-t-4 border-l-4 border-warna-400 rounded-tl-lg"></div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 border-t-4 border-r-4 border-warna-400 rounded-tr-lg"></div>
                            <div class="absolute -bottom-1 -left-1 w-6 h-6 border-b-4 border-l-4 border-warna-400 rounded-bl-lg"></div>
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 border-b-4 border-r-4 border-warna-400 rounded-br-lg"></div>
                            
                            <!-- Scanning line animation -->
                            <div x-show="isScanning && !showStatus" class="absolute top-1/2 left-0 w-full h-1 bg-warna-400 animate-pulse"></div>
                        </div>
                    </div>
                    
                    <!-- ✅ TAMBAHAN: Camera Switch Button (In-Camera) -->
                    <div x-show="isScanning && !showStatus && availableCameras.length > 1" 
                         class="absolute top-4 right-4 z-10">
                        <button @click="switchCamera()" 
                                class="p-3 bg-black bg-opacity-50 text-white rounded-full hover:bg-opacity-70 transition-all"
                                :title="isBackCamera ? 'Beralih ke Kamera Depan' : 'Beralih ke Kamera Belakang'">
                            <i class="fas fa-camera-rotate text-lg" x-show="isBackCamera"></i>
                            <i class="fas fa-camera text-lg" x-show="!isBackCamera"></i>
                        </button>
                    </div>
                    
                    <!-- Status Messages -->
                    <div x-show="showStatus" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         class="absolute inset-0 bg-black bg-opacity-75 flex items-center justify-center text-white text-center">
                        <div>
                            <div x-show="showSpinner" class="animate-spin rounded-full h-8 w-8 border-b-2 border-white mx-auto mb-2"></div>
                            <p x-text="statusMessage" class="text-sm">Memulai...</p>
                        </div>
                    </div>
                    
                    <!-- Processing indicator -->
                    @if($isProcessingAttendance)
                        <div class="absolute inset-0 bg-black bg-opacity-75 flex items-center justify-center">
                            <div class="text-white text-center">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white mx-auto mb-2"></div>
                                <p class="text-sm">Memproses absensi...</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- ✅ TAMBAHAN: Camera Info -->
                <div x-show="isScanning && !showStatus" class="mt-3 text-center">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-gray-100 rounded-full text-sm text-gray-600">
                        <i :class="isBackCamera ? 'fas fa-camera' : 'fas fa-camera-rotate'"></i>
                        <span x-text="isBackCamera ? 'Kamera Belakang' : 'Kamera Depan'"></span>
                    </div>
                </div>
                
                <!-- Instructions -->
                <div class="mt-4 space-y-2 text-xs text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2 w-4"></i>
                        <span>Posisikan QR Code di dalam frame putih</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2 w-4"></i>
                        <span>Pastikan pencahayaan cukup terang</span>
                    </div>
                    <div class="flex items-center" x-show="availableCameras.length > 1">
                        <i class="fas fa-sync-alt text-blue-500 mr-2 w-4"></i>
                        <span>Tap ikon switch untuk beralih kamera</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-refresh text-blue-500 mr-2 w-4"></i>
                        <span>Halaman akan refresh otomatis setelah scan berhasil</span>
                    </div>
                </div>
                
                <!-- Error Message -->
                <div x-show="hasError" class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2 mt-1"></i>
                        <div class="flex-1">
                            <p class="text-sm text-red-800 font-medium">Error:</p>
                            <p x-text="errorMessage" class="text-sm text-red-700"></p>
                            <button @click="retryCamera()" class="mt-2 text-sm text-red-600 hover:text-red-800 underline">
                                Coba Lagi
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Success Message -->
                <div x-show="cameraGranted && !hasError && !showStatus" class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <p class="text-sm text-green-800">Kamera aktif, arahkan ke QR Code</p>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                <button @click="closeScanner()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Tutup
                </button>
                
            </div>
        </div>
    </div>
@endif

    @if(session('message'))
        <div x-data="{ show: false }" 
            x-init="setTimeout(() => show = true, 100); setTimeout(() => show = false, 5000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-500 transform"
            x-transition:enter-start="opacity-0 translate-x-full scale-75"
            x-transition:enter-end="opacity-100 translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="opacity-100 translate-x-0 scale-100"
            x-transition:leave-end="opacity-0 translate-x-full scale-90"
            class="fixed top-4 right-4 z-50 bg-white border border-gray-200 rounded-lg shadow-lg p-4 max-w-sm">
            <div class="flex items-start">
               <div class="flex-shrink-0">
                  @if(session('message.type') === 'success')
                     <i class="fas fa-check-circle text-green-500"></i>
                  @elseif(session('message.type') === 'error')
                     <i class="fas fa-exclamation-circle text-red-500"></i>
                  @else
                     <i class="fas fa-info-circle text-blue-500"></i>
                  @endif
               </div>
               <div class="ml-3">
                  <h3 class="text-sm font-medium text-gray-900">{{ session('message.title') }}</h3>
                  <p class="text-sm text-gray-600 mt-1">{{ session('message.text') }}</p>
               </div>
               <button @click="show = false" class="ml-4 text-gray-400 hover:text-gray-600">
                  <i class="fas fa-times"></i>
               </button>
            </div>
        </div>
    @endif

    @if($showChangePasswordModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-warna-300/50 backdrop-blur-sm">
            <x-input-modal class="max-w-md w-full bg-white rounded-lg shadow-lg p-6 mx-5">
                <x-slot name="title">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Ubah Password</h2>
                        <button @click="show = false; setTimeout(() => $wire.toggleChangePasswordModal(), 200)" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </x-slot>
                <div class="w-full flex justify-end mb-1">
                    @if ($errors->any())
                        <div class="relative inline-block">
                            <button type="button" 
                                    class="flex items-center justify-center w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-full transition-colors duration-200"
                                    x-data="{ showErrors: false }"
                                    @mouseenter="showErrors = true"
                                    @mouseleave="showErrors = false"
                                    @click="showErrors = !showErrors">
                                <i class="fas fa-exclamation-triangle text-sm"></i>
                                
                                <!-- Tooltip with errors -->
                                <div x-show="showErrors"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95"
                                    class="absolute top-10 right-0 z-50 w-64 bg-white border border-red-200 rounded-lg shadow-lg p-3">
                                    <div class="text-red-600 text-sm">
                                        <div class="font-semibold mb-2">Error:</div>
                                        <ul class="space-y-1 text-xs">
                                            @foreach ($errors->all() as $error)
                                                <li class="flex items-start">
                                                    <i class="fas fa-circle text-xs mt-1.5 mr-2 text-warna-900"></i>
                                                    <span class="text-left">{{ $error }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- Arrow pointing up -->
                                    <div class="absolute -top-2 right-3 w-4 h-4 bg-white border-l border-t border-red-200 transform rotate-45"></div>
                                </div>
                            </button>
                        </div>
                    @endif
                    @if(session()->has('message'))
                        <div class="relative inline-block">
                            <button type="button" 
                                    class="flex items-center justify-center w-8 h-8 bg-green-100 hover:bg-green-200 text-green-600 rounded-full transition-colors duration-200"
                                    x-data="{ showMessage: false }"
                                    @mouseenter="showMessage = true"
                                    @mouseleave="showMessage = false"
                                    @click="showMessage = !showMessage">
                                <i class="fas fa-info-circle text-sm"></i>
                                
                                <!-- Tooltip with message -->
                                <div x-show="showMessage"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95"
                                    class="absolute top-10 right-0 z-50 w-64 bg-white border border-green-200 rounded-lg shadow-lg p-3">
                                    <div class="text-green-600 text-sm">
                                        <div class="font-semibold mb-2">Info:</div>
                                        <p class="text-xs">{{ session('message') }}</p>
                                    </div>
                                    <!-- Arrow pointing up -->
                                    <div class="absolute -top-2 right-3 w-4 h-4 bg-white border-l border-t border-green-200 transform rotate-45"></div>
                                </div>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="space-y-4">
                    <x-g-input 
                        label="Password Lama"
                        type="password"
                        wire:model.defer="oldPassword"
                        placeholder="Masukkan password lama"
                     />
                    <x-g-input
                        label="Password Baru"
                        type="password"
                        wire:model.defer="newPassword"
                        placeholder="Masukkan password baru"
                     />
                    <x-g-input
                        label="Konfirmasi Password Baru"
                        type="password"
                        wire:model.defer="confirmNewPassword"
                        placeholder="Konfirmasi password baru"
                    />   
                </div>
                <x-slot name="actions">
                    <button wire:click="changePassword" 
                        wire:loading.attr="disabled"
                        wire:target="changePassword"
                        class="px-5 py-2 bg-warna-400 hover:bg-warna-400/80 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-lg transition-all active:scale-95">
                        <span wire:loading.remove wire:target="changePassword">Simpan</span>
                        <span wire:loading wire:target="changePassword">Menyimpan...</span>
                    </button>
                </x-slot>
            </x-input-modal>
        </div>
    @endif

</div>
