<div class="min-h-screen">
    <!---mobile-->
    <div class="w-full max-w-lg mx-auto lg:hidden ">
        <div class="mt-10 mb-5">
            <h3 class="text-sm font-medium">Selamat Datang Kembali,</h3>
            <h1 class="text-xl font-bold text-warna-300">{{ Auth::user()->name }}</h1>
        </div>
        <div class="mt-6 bg-white px-4 py-5 rounded-lg w-full shadow-md">
            <div class="flex w-full items-center justify-between">

                <div class="">
                    <h2 class="text-lg font-semibold">Absensi Hari Ini</h2>
                    <p class="text-sm text-warna-200/80">{{ now()->format('d F Y') }}</p>
                </div>
                <div class="w-13 h-13 {{ $isAttendedToday ? 'bg-warna-700' : 'bg-warna-900' }} rounded-lg flex items-center justify-center">
                    
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
            <div class="flex items-center justify-between mb-4 ">
                <h3 class="text-lg font-semibold">Riwayat Absensi</h3>
                <span class="text-sm text-warna-600 font-medium">{{ $persentaseKehadiran }}</span>
            </div>

            <!--month & year selector-->
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

            <!--header hari-->
            <div class="grid grid-cols-7 gap-1 mb-2">
                @foreach(['S', 'S', 'R', 'K', 'J', 'S', 'M'] as $day)
                    <div class="text-center text-xs font-medium text-gray-500 py-1">
                        {{ $day }}
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-7 gap-1 mb-4">
                @foreach($calendarDays as $day)
                    <div class="relative h-8 flex items-center justify-center text-xs border border-gray-200 rounded
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
                            <div class="absolute -top-0.5 -right-0.5">
                                <div class="w-3 h-3 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-2 gap-3 text-center">
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="text-lg font-bold text-green-600">{{ $attendanceStats['attendedDays'] ?? 0 }}</div>
                    <div class="text-xs text-gray-600">Hari Hadir</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="text-lg font-bold text-warna-600">{{ $attendanceStats['membershipActiveDays'] ?? 0 }}</div>
                    <div class="text-xs text-gray-600">Hari Aktif</div>
                </div>
            </div>
        </div>

    </div>

    <!--floating button for absense-->
    <div class="fixed bottom-4 right-4 z-30 lg:hidden">
        <button wire:click="testAbsen" class="w-max h-max bg-warna-400 hover:bg-warna-400/80  shadow-lg transition-all px-4 py-3 text-white font-semibold  rounded-2xl flex items-center justify-center active:scale-95">
            <i class="bi bi-qr-code-scan text-2xl    "></i>
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
                                    <span class="text-xs text-gray-500 bg-red-100 px-2 py-1 rounded-full">hari</span>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Tidak Hadir</h3>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <div class="bg-warna-900 h-2 rounded-full" style="width: {{ min(100, $totalTidakHadir) }}%"></div>
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
                                <div class="bg-warna-600 h-2 rounded-full" style="width: {{ $sisaHariAktif > 0 ? min(100, ($sisaHariAktif / 30) * 100) : 0 }}%"></div>
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
                                    @if($isAttendedToday)
                                    <span class="text-xs text-green-600 font-medium ml-2">✓ Sudah Absen</span>
                                    @else
                                        <span class="text-xs text-orange-600 font-medium ml-2">Belum Absen</span>
                                    @endif
                                </h3>
                                <p class="text-sm text-gray-600">{{ now()->format('d F Y') }}</p>
                                
                            </div>
                        </div>
                        <div>
                            <button wire:click="testAbsen" 
                            class="bg-warna-400 hover:bg-warna-400/80 text-white font-semibold py-2 px-4 rounded-lg transition-all active:scale-95 flex items-center justify-center gap-3
                            {{ $isAttendedToday ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $isAttendedToday ? 'disabled' : '' }}>
                                <i class="bi bi-qr-code-scan text-2xl"></i>
                                {{ $isAttendedToday ? 'Sudah Absen' : 'Absen Sekarang' }}
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



</div>
