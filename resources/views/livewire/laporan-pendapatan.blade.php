<div>
<div class="pb-9 bg-gray-100">
     <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                
                <div class="min-w-0 bg-linear-to-br from-emerald-700 to-teal-800 text-white p-6 rounded-2xl shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-white/85 text-sm font-medium">Pendapatan Hari Ini</p>
                            <p class="mt-3 text-2xl font-bold tracking-tight break-words">Rp {{ number_format($today ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                
                <div class="min-w-0 bg-linear-to-br from-sky-700 to-blue-800 text-white p-6 rounded-2xl shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-white/85 text-sm font-medium">Bulan Ini</p>
                            <p class="mt-3 text-2xl font-bold tracking-tight break-words">Rp {{ number_format($thisMonth ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                
                <div class="min-w-0 bg-linear-to-br from-orange-600 to-amber-700 text-white p-6 rounded-2xl shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-white/85 text-sm font-medium">Total Semua</p>
                            <p class="mt-3 text-2xl font-bold tracking-tight break-words">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
</div>




    <div class="h-full p-6 bg-white rounded-lg">
        
        <!-- Riwayat Transaksi Hari Ini -->
         <div class="flex items-center gap-4 mb-4">
            <!-- Pilih Bulan -->
            <div>
                <label class="text-sm text-gray-600">Bulan:</label>
                <select wire:model.live="selectedMonth" class="text-sm border border-gray-300 rounded px-2 py-1">
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}">{{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Tahun -->
            <div>
                <label class="text-sm text-gray-600">Tahun:</label>
                <select wire:model.live="selectedYear" class="text-sm w-20 border border-gray-300 rounded px-2 py-1">
                   @foreach(range(2022, now()->year) as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <button wire:click="exportExcel"
                class="text-sm px-4 py-2 bg-warna-500 text-white rounded hover:bg-warna-600 transition">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </button>

        </div>

        <div>
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold">
                Riwayat Transaksi bulan {{
                    \DateTime::createFromFormat('!m', $selectedMonth)->format('F')
                }}
            </h3>

            <div class="flex items-center gap-4">
                <!-- Items per page selector -->
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-600">Show:</label>
                    <select wire:model.live="perPage" 
                            class="text-sm w-14 border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-warna-400 focus:border-warna-400">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                    </select>
                    <span class="text-sm text-gray-600">per page</span>
                </div>
                
                <div class="text-sm text-gray-600">
                    Total: {{ count($this->todayTransactions ?? []) }} transaksi
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-warna-200">
                    <thead class="w-full text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700 uppercase">Waktu</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700 uppercase">Tipe Transaksi</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700 uppercase">Deskripsi</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700 uppercase">Pembayaran</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-700 uppercase">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($this->todayTransactions ?? [] as $transaction)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-900">
                                    {{ $transaction->transaction_datetime->format('d-m-Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $transaction->transaction_type === 'membership_payment' ? 'bg-blue-100 text-blue-800' : 
                                           ($transaction->transaction_type === 'daily_visit_fee' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                                        @switch($transaction->transaction_type)
                                            @case('membership_payment')
                                                <i class="fas fa-users mr-1"></i>
                                                Membership
                                                @break
                                            @case('daily_visit_fee')
                                                <i class="fas fa-clock mr-1"></i>
                                                Harian
                                                @break
                                            @case('additional_items_sale')
                                                <i class="fas fa-shopping-cart mr-1"></i>
                                                Produk
                                                @break
                                            @default
                                                {{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}
                                        @endswitch
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-600">
                                    @if($transaction->description)
                                        {{ Str::limit($transaction->description, 50) }}
                                    @else
                                        <span class="italic text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs
                                        {{ $transaction->payment_method === 'cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        @if($transaction->payment_method === 'cash')
                                            <i class="fas fa-money-bill mr-1"></i>
                                            Tunai
                                        @else
                                            <i class="fas fa-qrcode mr-1"></i>
                                            QRIS
                                        @endif
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-warna-600">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-3xl mb-3 block text-gray-300"></i>
                                    <p>Belum ada transaksi hari ini</p>
                                    <p class="text-xs mt-1">Transaksi akan muncul setelah Anda melakukan penjualan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Controls -->
            <x-table-pagination :paginator="$this->todayTransactions" label="transaksi" />
            
            <!-- Summary Footer -->
            @if($this->todayTransactions->count() > 0)
                <div class="bg-gray-50 px-4 py-3 border-t">
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-bold text-warna-600">
                            Total Pendapatan: Rp {{ number_format($mountTotal ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>