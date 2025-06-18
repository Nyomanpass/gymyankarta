<!-- resources/views/livewire/dashboard.blade.php -->
<div class="flex flex-col space-y-8">
    
    <!-- ✅ KATEGORI 1: RINGKASAN KEUANGAN -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-chart-line text-green-600 mr-3"></i>
            Ringkasan Keuangan
        </h2>
        
        <!-- Main Financial Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Pendapatan Hari Ini --}}
            <div class="bg-gradient-to-r from-warna-700 to-green-500 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                <p class="text-sm text-green-100">Pendapatan Hari Ini</p>
                <p class="text-2xl font-bold">Rp {{ number_format($todayRevenue ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                <i class="fas fa-coins text-xl"></i>
                </div>
            </div>
            </div>

            {{-- Pendapatan Bulan Ini --}}
            <div class="bg-gradient-to-r from-warna-700 to-green-500 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                <p class="text-sm text-green-100">Pendapatan Bulan Ini</p>
                <p class="text-2xl font-bold">Rp {{ number_format($thisMonthRevenue ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                <i class="fas fa-calendar-alt text-xl"></i>
                </div>
            </div>
            </div>

            {{-- Pendapatan Tahun Ini --}}
            <div class="bg-gradient-to-r from-warna-700 to-green-500 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                <p class="text-sm text-green-100">Pendapatan Tahun Ini</p>
                <p class="text-2xl font-bold">Rp {{ number_format($thisYearRevenue ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                <i class="fas fa-chart-bar text-xl"></i>
                </div>
            </div>
            </div>
        </div>

        <!-- Revenue Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Membership</p>
                        <p class="text-xl font-bold text-gray-800">Rp {{ number_format($revenueByType['membership'] ?? 0, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Bulan ini</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-id-card text-warna-700"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Daily Visit</p>
                        <p class="text-xl font-bold text-gray-800">Rp {{ number_format($revenueByType['daily_visit'] ?? 0, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Bulan ini</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-ticket-alt text-warna-700"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Produk</p>
                        <p class="text-xl font-bold text-gray-800">Rp {{ number_format($revenueByType['products'] ?? 0, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Bulan ini</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-shopping-bag text-warna-700"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ KATEGORI 2: RINGKASAN MEMBER -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-users text-blue-600 mr-3"></i>
            Ringkasan Member
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- Total Member --}}
            <div class="bg-gradient-to-r from-gray-500 to-gray-400 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-100">Total Member</p>
                        <p class="text-2xl font-bold">{{ $totalMembers }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Member Aktif --}}
            <div class="bg-gradient-to-r from-green-500 to-green-400 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-green-100">Member Aktif</p>
                        <p class="text-2xl font-bold">{{ $totalActive }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <i class="fas fa-user-check text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Member Frozen --}}
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-yellow-100">Member Frozen</p>
                        <p class="text-2xl font-bold">{{ $totalFrozen }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <i class="fas fa-snowflake text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Member Inactive --}}
            <div class="bg-gradient-to-r from-red-500 to-red-400 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-red-100">Member Inactive</p>
                        <p class="text-2xl font-bold">{{ $totalInactive }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <i class="fas fa-user-times text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Pending Verifikasi --}}
            <div class="bg-gradient-to-r from-orange-500 to-orange-400 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-orange-100">Pending Verifikasi</p>
                        <p class="text-2xl font-bold">{{ $totalPendingAdmin }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <i class="fas fa-user-shield text-xl"></i>
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
                        <div class="bg-red-100 p-3 rounded-full">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
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
            <i class="fas fa-dumbbell text-warna-600 mr-3"></i>
            Ringkasan Aktivitas Gym
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Total Pengunjung Hari Ini --}}
            <div class="bg-gradient-to-r from-warna-600 to-blue-500 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-100">Total Pengunjung Hari Ini</p>
                        <p class="text-2xl font-bold">{{ $totalVisitorsToday }}</p>
                        <p class="text-xs text-blue-200 mt-1">Member + Daily Visit</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <i class="fas fa-door-open text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Absensi Member Hari Ini --}}
            <div class="bg-gradient-to-r from-warna-600 to-blue-500 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-100">Absensi Member</p>
                        <p class="text-2xl font-bold">{{ $memberAttendanceToday }}</p>
                        <p class="text-xs text-blue-200 mt-1">Hari ini</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <i class="fas fa-clipboard-check text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Pengunjung Harian --}}
            <div class="bg-gradient-to-r from-warna-600 to-blue-500 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-100">Pengunjung Harian</p>
                        <p class="text-2xl font-bold">{{ $dailyVisitorsToday }}</p>
                        <p class="text-xs text-blue-200 mt-1">Hari ini</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <i class="fas fa-walking text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Absensi Minggu Ini --}}
            <div class="bg-gradient-to-r from-warna-600 to-blue-500 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-100">Absensi Minggu Ini</p>
                        <p class="text-2xl font-bold">{{ $thisWeekAttendance }}</p>
                        <p class="text-xs text-blue-200 mt-1">Total member</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <i class="fas fa-calendar-week text-xl"></i>
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
                <i class="fas fa-chart-line text-warna-400 mr-2"></i>
                Pendapatan Bulanan {{ date('Y') }}
            </h3>
            <div wire:ignore class="relative w-full" style="height: 300px;"> 
                <canvas id="monthlyRevenueChart" class="w-full h-full"></canvas>
            </div>
        </div>

        {{-- Top Products --}}
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-trophy text-warna-400 mr-2"></i>
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
                        <i class="fas fa-box-open text-4xl mb-2"></i>
                        <p>Belum ada produk terjual bulan ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ✅ QUICK ACTIONS -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-bolt text-yellow-600 mr-2"></i>
            Quick Actions
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <a href="{{ route('kelola.pendapatan') }}" 
               class="flex flex-col items-center p-4 bg-white hover:bg-gray-50 rounded-lg transition-colors border border-gray-200 shadow-sm">
                <i class="fas fa-plus-circle text-2xl text-warna-400 mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Transaksi Baru</span>
            </a>
            <a href="{{ route('kelola.member') }}" 
               class="flex flex-col items-center p-4 bg-white hover:bg-gray-50 rounded-lg transition-colors border border-gray-200 shadow-sm">
                <i class="fas fa-users text-2xl text-warna-400 mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Kelola Member</span>
            </a>
            <a href="{{ route('pengaturan.harga') }}" 
               class="flex flex-col items-center p-4 bg-white hover:bg-gray-50 rounded-lg transition-colors border border-gray-200 shadow-sm">
                <i class="fas fa-cog text-2xl text-warna-400 mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Pengaturan</span>
            </a>
            <a href="{{ route('laporan.pendapatan') }}" 
               class="flex flex-col items-center p-4 bg-white hover:bg-gray-50 rounded-lg transition-colors border border-gray-200 shadow-sm">
                <i class="fas fa-chart-bar text-2xl text-warna-400 mb-2"></i>
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