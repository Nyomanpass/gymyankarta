
<div class="flex flex-col">
 <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    {{-- Card: Member Aktif --}}
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

    {{-- Card: Pending Verifikasi --}}
    <div class="bg-gradient-to-r from-blue-500 to-blue-400 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-blue-100">Pending Verifikasi</p>
                <p class="text-2xl font-bold">{{ $totalPendingAdmin }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full">
                <i class="fas fa-user-shield text-xl"></i>
            </div>
        </div>
    </div>

    {{-- Card: Pendapatan Bulan Ini --}}
    <div class="bg-gradient-to-r from-warna-400 to-warna-500 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-blue-100">Pendapatan Bulan Ini</p>
                <p class="text-2xl font-bold">Rp {{ number_format($thisMonth ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full">
                <i class="fas fa-calendar-alt text-xl"></i>
            </div>
        </div>
    </div>
</div>


    <div class="mx-auto w-full">
        <div wire:ignore class="h-[60vh] w-full"> 
            <canvas id="monthlyRevenueChart" class="h-full w-full block"></canvas>
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
                backgroundColor: '#404040',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
