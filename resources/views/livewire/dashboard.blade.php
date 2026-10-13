<!-- resources/views/livewire/dashboard.blade.php -->
<div class="flex flex-col space-y-10">
    
    <!-- ✅ KATEGORI 1: RINGKASAN KEUANGAN -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            Ringkasan Keuangan
        </h2>
        
        <!-- Warna kartu menggunakan utility Tailwind agar mudah disesuaikan. -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach([
                ['Pendapatan Hari Ini', $todayRevenue ?? 0, 'from-emerald-700 to-teal-800'],
                ['Pendapatan Bulan Ini', $thisMonthRevenue ?? 0, 'from-sky-700 to-blue-800'],
                ['Pendapatan Tahun Ini', $thisYearRevenue ?? 0, 'from-orange-600 to-amber-700'],
            ] as [$label, $amount, $gradient])
                <div class="min-w-0 rounded-2xl bg-linear-to-br {{ $gradient }} p-5 sm:p-6 text-white shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-white/85">{{ $label }}</p>
                            <p class="mt-3 text-2xl xl:text-3xl font-bold tracking-tight break-words">Rp {{ number_format($amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach([
                ['Membership', $revenueByType['membership'] ?? 0, 'bg-emerald-50 border-emerald-200'],
                ['Daily Visit', $revenueByType['daily_visit'] ?? 0, 'bg-sky-50 border-sky-200'],
                ['Produk', $revenueByType['products'] ?? 0, 'bg-orange-50 border-orange-200'],
            ] as [$label, $amount, $surface])
                <div class="min-w-0 rounded-2xl border {{ $surface }} p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-warna-300">{{ $label }}</p>
                            <p class="mt-2 text-xl xl:text-2xl font-bold tracking-tight text-warna-300 break-words">Rp {{ number_format($amount, 0, ',', '.') }}</p>
                            <p class="text-xs text-warna-200 mt-2">Bulan ini</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ✅ KATEGORI 2: RINGKASAN MEMBER -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            Ringkasan Member
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
            {{-- Total Member --}}
            <div class="metric-card bg-gradient-to-r from-gray-500 to-gray-400 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-100">Total Member</p>
                        <p class="text-2xl font-bold">{{ $totalMembers }}</p>
                    </div>
                </div>
            </div>

            {{-- Member Aktif --}}
            <div class="metric-card bg-gradient-to-r from-green-500 to-green-400 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-green-100">Member Aktif</p>
                        <p class="text-2xl font-bold">{{ $totalActive }}</p>
                    </div>
                </div>
            </div>

            {{-- Member Frozen --}}
            <div class="metric-card bg-gradient-to-r from-yellow-500 to-yellow-400 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-yellow-100">Member Frozen</p>
                        <p class="text-2xl font-bold">{{ $totalFrozen }}</p>
                    </div>
                </div>
            </div>

            {{-- Member Inactive --}}
            <div class="metric-card bg-gradient-to-r from-red-500 to-red-400 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-red-100">Member Inactive</p>
                        <p class="text-2xl font-bold">{{ $totalInactive }}</p>
                    </div>
                </div>
            </div>

            {{-- Pending Verifikasi --}}
            <div class="metric-card bg-gradient-to-r from-orange-500 to-orange-400 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-orange-100">Pending Verifikasi</p>
                        <p class="text-2xl font-bold">{{ $totalPendingAdmin }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Member Additional Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Member Type Distribution --}}
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Tipe Member</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                            <span class="font-medium">Local Member</span>
                        </div>
                        <span class="font-bold text-blue-600">{{ $membershipDistribution['local'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                            <span class="font-medium">Foreign Member</span>
                        </div>
                        <span class="font-bold text-green-600">{{ $membershipDistribution['foreign'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            {{-- Expiring Soon --}}
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Member Akan Expired</h3>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div>
                            <span class="font-medium text-gray-800">Dalam 7 Hari</span>
                            <p class="text-sm text-gray-500">Perlu perpanjangan segera</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-red-600">{{ $expiringSoon }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ KATEGORI 3: RINGKASAN AKTIVITAS GYM -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            Ringkasan Aktivitas Gym
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            {{-- Total Pengunjung Hari Ini --}}
            <div class="metric-card bg-gradient-to-r from-warna-600 to-blue-500 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-100">Total Pengunjung Hari Ini</p>
                        <p class="text-2xl font-bold">{{ $totalVisitorsToday }}</p>
                        <p class="text-xs text-blue-200 mt-1">Member + Daily Visit</p>
                    </div>
                </div>
            </div>

            {{-- Absensi Member Hari Ini --}}
            <div class="metric-card bg-gradient-to-r from-warna-600 to-blue-500 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-100">Absensi Member</p>
                        <p class="text-2xl font-bold">{{ $memberAttendanceToday }}</p>
                        <p class="text-xs text-blue-200 mt-1">Hari ini</p>
                    </div>
                </div>
            </div>

            {{-- Pengunjung Harian --}}
            <div class="metric-card bg-gradient-to-r from-warna-600 to-blue-500 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-100">Pengunjung Harian</p>
                        <p class="text-2xl font-bold">{{ $dailyVisitorsToday }}</p>
                        <p class="text-xs text-blue-200 mt-1">Hari ini</p>
                    </div>
                </div>
            </div>

            {{-- Absensi Minggu Ini --}}
            <div class="metric-card bg-gradient-to-r from-warna-600 to-blue-500 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-100">Absensi Minggu Ini</p>
                        <p class="text-2xl font-bold">{{ $thisWeekAttendance }}</p>
                        <p class="text-xs text-blue-200 mt-1">Total member</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ CHARTS & ADDITIONAL INFO -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Chart: Monthly Revenue --}}
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                Pendapatan Bulanan {{ date('Y') }}
            </h3>
            <div wire:ignore class="relative w-full" style="height: 300px;"> 
                <canvas id="monthlyRevenueChart" class="w-full h-full"></canvas>
            </div>
        </div>

        {{-- Top Products --}}
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                Produk Terlaris Bulan Ini
            </h3>
            <div class="overflow-hidden">
                @if($topProducts && $topProducts->count() > 0)
                    <div class="space-y-3">
                        @foreach($topProducts as $index => $product)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-warna-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $product->name }}</span>
                                </div>
                                <span class="text-sm font-semibold text-warna-600">{{ $product->total_sold }} terjual</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>Belum ada produk terjual bulan ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ✅ QUICK ACTIONS -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            Akses Cepat
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <a href="{{ route('kelola.pendapatan') }}" 
               class="flex items-center justify-center px-4 py-3 bg-gray-50 hover:bg-orange-50 rounded-lg transition-colors border border-gray-200">
                <span class="text-sm font-medium text-gray-700">Transaksi Baru</span>
            </a>
            <a href="{{ route('kelola.member') }}" 
               class="flex items-center justify-center px-4 py-3 bg-gray-50 hover:bg-orange-50 rounded-lg transition-colors border border-gray-200">
                <span class="text-sm font-medium text-gray-700">Kelola Member</span>
            </a>
            <a href="{{ route('pengaturan.harga') }}" 
               class="flex items-center justify-center px-4 py-3 bg-gray-50 hover:bg-orange-50 rounded-lg transition-colors border border-gray-200">
                <span class="text-sm font-medium text-gray-700">Pengaturan</span>
            </a>
            <a href="{{ route('laporan.pendapatan') }}" 
               class="flex items-center justify-center px-4 py-3 bg-gray-50 hover:bg-orange-50 rounded-lg transition-colors border border-gray-200">
                <span class="text-sm font-medium text-gray-700">Laporan</span>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyRevenueChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Pendapatan per Bulan',
                data: {!! json_encode($monthlyRevenue) !!},
                backgroundColor: '#f48801',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 0
                    }
                }
            }
        }
    });
</script>
@endpush