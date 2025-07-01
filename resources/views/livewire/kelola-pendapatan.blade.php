<div class="">
    <div class="flex gap-3">
        <div class="w-full xl:w-[70%] p-6 bg-white rounded-lg">
            <div class="flex items-center justify-between mb-8">
                <p class="text-lg lg:text-xl font-semibold ">Tambah Data Transaksi</p>
                {{-- @if($isNotificationModalOpen)
                    <div>
                        <p>{{ session('message.description') }}</p>
                    </div>
                @endif --}}
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
            </div>
            <form wire:submit.prevent="save" class="space-y-5">
                <x-g-input 
                    id="transaction_type"
                    label="Tipe Transaksi"
                    type="select"
                    name="transaction_type"
                    wire:model.live="transaction_type"
                    :options="[
                        'membership_payment' => 'Pembayaran Membership',
                        'daily_visit_fee' => 'Pengunjung Harian', 
                        'additional_items_sale' => 'Additional Item',
                    ]"
                />
                

                @if ($transaction_type === 'membership_payment')
                    <!-- Pilih Member -->
                    <x-g-input 
                        label="Pilih Member"
                        type="searchable-select"
                        name="selectedMember"
                        wire:model.live="selectedMember"
                        :options="$memberOptions"
                        placeholder="Pilih Member..."
                        search-placeholder="Cari nama atau email member..."
                        display-key="name"
                        value-key="id"
                        :search-keys="['name', 'email']"
                        no-results-text="Tidak ada member ditemukan"
                    />


                    @if($selectedMember && $selectedMemberData)

                        <!-- Member Type (muncul jika member belum punya member_type) -->
                        @if(!$selectedMemberData->member_type)
                            <x-g-input 
                                label="Jenis Member"
                                type="select"
                                name="member_type"
                                wire:model.live="member_type"
                                :options="$memberTypeOptions"
                                
                            />
                        @else
                            <x-g-input 
                                label="Jenis Member"
                                type="text"
                                value="{{ $selectedMemberData->member_type }}"
                                disabled
                                class="disabled:bg-gray-100 disabled:text-gray-700 disabled:cursor-not-allowed"
                            />
                        @endif

                        <!-- Durasi Membership (muncul untuk semua member type) -->
                        @if($member_type || $selectedMemberData->member_type)
                            <x-g-input 
                                label="Durasi Keanggotaan"
                                type="select"
                                name="duration_membership"
                                wire:model.live="duration_membership"
                                :options="$durationOptions"
                            />
                        @endif

                    @endif

                @elseif($transaction_type === 'additional_items_sale')
                    <p class="text-xs text-warna-200/80 mb-4">Semua Produk</p>
                    <!--grid card semua produk-->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        @forelse($products as $product)
                            <div class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition-shadow cursor-pointer"
                                wire:click="addProductToCart({{ $product->id }})">
                                <div class="aspect-square mb-2">
                                    @if($product->image)
                                        <img src="/storage/{{ $product->image }}" 
                                            alt="{{ $product->name }}" 
                                            class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <h4 class="font-semibold text-sm text-gray-800 mb-1 line-clamp-2">{{ $product->name }}</h4>
                                
                                @if($product->description)
                                    <p class="text-xs text-gray-500 mb-2 line-clamp-1">{{ $product->description }}</p>
                                @endif
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-bold text-warna-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    
                                    @if(isset($selectedProducts[$product->id]))
                                        <span class="bg-warna-500 text-white text-xs px-2 py-1 rounded-full">
                                            {{ $selectedProducts[$product->id]['quantity'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <i class="fas fa-box-open text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">Tidak ada produk tersedia</p>
                            </div>
                        @endforelse
                    </div>
                @elseif($transaction_type === 'daily_visit_fee')
                    <x-g-input 
                        label="Tipe Pengunjung"
                        type="select"
                        name="visitor_type"
                        wire:model.live="visitor_type"
                        :options="[
                            'local' => 'Local',
                            'foreign' => 'Foreign'
                        ]"
                    />
                @endif
                <x-g-input 
                    label="Deskripsi (Opsional)"
                    type="text"
                    name="description"
                    wire:model.live="description"
                    
                />

                <x-g-input 
                    label="Metode Pembayaran"
                    type="select"
                    name="payment_method"
                    wireModel="payment_method"
                    :options="[
                        'cash' => 'Tunai',
                        'qris' => 'QRIS',
                    ]"
                    
                />
                
                <button type="submit" 
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-50"
                        class="mt-4 w-full bg-warna-400 text-white font-semibold py-2 md:py-3 px-4 rounded-lg hover:bg-warna-500 transition-colors duration-200">
                    <span wire:loading.remove>Simpan</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </form>
            
        </div>

        <div class="hidden xl:block w-full lg:w-1/3 bg-white rounded-lg p-6">
            <p class="text-lg lg:text-xl font-semibold mb-8">Detail Transaksi</p>
            
            @if($transaction_type === 'additional_items_sale' && !empty($selectedProducts))
                <div class="space-y-4">
                    <!-- Header Produk Terpilih -->
                    <div class="border-b pb-3">
                        <h4 class="font-semibold text-gray-800">Produk Terpilih</h4>
                    </div>
                    
                    <!-- List Produk -->
                    <div class="space-y-3 max-h-60 overflow-y-auto">
                        @foreach($selectedProducts as $productId => $item)
                            <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</h5>
                                    <p class="text-xs text-gray-500">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-1">
                                        <button type="button" 
                                                wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] - 1 }})"
                                                class="w-6 h-6 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center text-xs">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        
                                        <span class="w-8 text-center text-sm font-medium">{{ $item['quantity'] }}</span>
                                        
                                        <button type="button" 
                                                wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] + 1 }})"
                                                class="w-6 h-6 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center text-xs">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Remove Button -->
                                    <button type="button" 
                                            wire:click="removeProduct({{ $productId }})"
                                            class="w-6 h-6 bg-red-100 hover:bg-red-200 text-red-600 rounded-full flex items-center justify-center text-xs">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Subtotal -->
                            <div class="text-right text-sm text-gray-600 mt-1">
                                Subtotal: Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Total -->
                    <div class="border-t pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-800">Total:</span>
                            <span class="text-lg font-bold text-warna-600">
                                Rp {{ number_format($totalAmount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @elseif($transaction_type === 'membership_payment' && $selectedMember && $selectedMemberData)
                <div class="space-y-4">
                    <div class="border-b pb-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Ringkasan Pembayaran</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tipe:</span>
                                <span class="font-medium">Pembayaran Membership</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Member:</span>
                                <span class="font-medium">{{ $selectedMemberData->name }}</span>
                            </div>
                            @if($member_type || $selectedMemberData->member_type)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jenis:</span>
                                    <span class="font-medium">{{ ucfirst($member_type ?: $selectedMemberData->member_type) }}</span>
                                </div>
                            @endif
                            @if($duration_membership)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Durasi:</span>
                                    <span class="font-medium">{{ $durationOptions[$duration_membership] ?? $duration_membership }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if($membershipTotal > 0)
                        <div class="border-t pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-800">Total:</span>
                                <span class="text-lg font-bold text-warna-600">
                                    Rp {{ number_format($membershipTotal, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <div class="mt-2 text-xs text-gray-500">
                                <p>* Harga {{ ucfirst($member_type ?: $selectedMemberData->member_type) }} - 
                                @switch($duration_membership)
                                    @case('one_week')
                                        1 Minggu
                                        @break
                                    @case('two_weeks')
                                        2 Minggu
                                        @break
                                    @case('three_weeks')
                                        3 Minggu
                                        @break
                                    @case('one_month')
                                        1 Bulan
                                        @break
                                @endswitch
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            @elseif($transaction_type === 'daily_visit_fee')
                <div class="space-y-4">
                    <div class="mb-7 md:mb-9">
                        <h4 class="font-semibold text-gray-800 mb-3">Ringkasan Pengunjung Harian</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tipe:</span>
                                <span class="font-medium">Pengunjung Harian</span>
                            </div>
                            <!-- ✅ TAMBAHKAN: Info tipe pengunjung -->
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tipe Pengunjung:</span>
                                <span class="font-medium">{{ ucfirst($visitor_type) }}</span>
                            </div>
                            @if($description)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Deskripsi:</span>
                                    <span class="font-medium">{{ $description }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="border-t pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-800">Total:</span>
                            <span class="text-lg font-bold text-warna-600">
                                Rp {{ number_format($dailyVisitTotal, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="mt-2 text-xs text-gray-500">
                            <!-- ✅ UPDATE: Tunjukkan tipe dalam keterangan -->
                            <p>* Tarif pengunjung harian {{ $visitor_type }} per orang</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-receipt text-gray-400 text-3xl mb-3"></i>
                    <p class="text-gray-500">Detail transaksi akan muncul di sini</p>
                </div>
            @endif
        </div>

    </div>

    <div class="hidden lg:block mt-10 h-full p-6 bg-white rounded-lg">
        <!-- Total Transaksi Hari Ini -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-6 ">Total Transaksi Hari Ini</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Keseluruhan -->
                <div class="bg-gradient-to-r from-warna-400 to-warna-500 text-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-warna-100 text-sm font-medium">Total Keseluruhan</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($totalToday ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-full">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Membership -->
                <div class="bg-gradient-to-r from-blue-400 to-blue-500 text-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Membership</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($membershipToday ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-full">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Produk & Harian -->
                <div class="bg-gradient-to-r from-green-400 to-green-500 text-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Produk & Harian</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($otherToday ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-full">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Transaksi Hari Ini -->
        <div>
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold">Riwayat Transaksi Hari Ini</h3>
            <div class="flex items-center gap-4">
                <!-- Items per page selector -->
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-600">Show:</label>
                    <select wire:model.live="perPage" 
                            class="text-sm border w-16 border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-warna-400 focus:border-warna-400">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                    </select>
                    <span class="text-sm text-gray-600">per page</span>
                </div>
                
                <div class="text-sm text-gray-600">
                    Total: {{ count($todayTransactions ?? []) }} transaksi
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
                            <th class="px-4 py-3 text-center font-semibold text-gray-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($todayTransactions ?? [] as $transaction)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-900">
                                    {{ $transaction->transaction_datetime->format('H:i') }}
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
                                <td class="px-4 py-3 text-center">
                                    <button 
                                        wire:click="confirmDeleteTransaction({{ $transaction->id }})"
                                        class="inline-flex items-center px-2 py-1 bg-red-100 hover:bg-red-200 text-red-600 text-xs font-medium rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        title="Hapus Transaksi"
                                    >
                                        <i class="fas fa-trash text-xs"></i>
                                        <span class="ml-1 hidden sm:inline">Hapus</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
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
            @if($this->todayTransactions->hasPages())
                <div class="bg-gray-50 px-4 py-3 border-t">
                    <div class="flex items-center justify-between">
                        <!-- Pagination Info -->
                        <div class="text-sm text-gray-600">
                            Showing {{ $this->todayTransactions->firstItem() }} to {{ $this->todayTransactions->lastItem() }} 
                            of {{ $this->todayTransactions->total() }} results
                        </div>
                        
                        <!-- Pagination Links -->
                        <div class="flex items-center space-x-2">
                            <!-- Previous Button -->
                            @if ($this->todayTransactions->onFirstPage())
                                <span class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded cursor-not-allowed">
                                    <i class="fas fa-chevron-left mr-1"></i>Previous
                                </span>
                            @else
                                <button wire:click="previousPage" 
                                        class="px-3 py-1 text-sm text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-chevron-left mr-1"></i>Previous
                                </button>
                            @endif
                            
                            <!-- Page Numbers -->
                            @if($this->todayTransactions->lastPage() > 1)
                                @for($i = 1; $i <= $this->todayTransactions->lastPage(); $i++)
                                    @if($i == $this->todayTransactions->currentPage())
                                        <span class="px-3 py-1 text-sm bg-warna-500 text-white rounded font-medium">
                                            {{ $i }}
                                        </span>
                                    @else
                                        <button wire:click="gotoPage({{ $i }})" 
                                                class="px-3 py-1 text-sm text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                            {{ $i }}
                                        </button>
                                    @endif
                                @endfor
                            @endif
                            
                            <!-- Next Button -->
                            @if ($this->todayTransactions->hasMorePages())
                                <button wire:click="nextPage" 
                                        class="px-3 py-1 text-sm text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                    Next<i class="fas fa-chevron-right ml-1"></i>
                                </button>
                            @else
                                <span class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded cursor-not-allowed">
                                    Next<i class="fas fa-chevron-right ml-1"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Summary Footer -->
            @if($todayTransactions->count() > 0)
                <div class="bg-gray-50 px-4 py-3 border-t">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">
                            Page {{ $todayTransactions->currentPage() }} of {{ $todayTransactions->lastPage() }}
                        </span>
                        <span class="font-bold text-warna-600">
                            Total Hari Ini: Rp {{ number_format($totalToday ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>
    </div>

    @if($isNotificationModalOpen)
     <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
       <x-notification-modal class="relative bg-white rounded-lg shadow-lg p-6 mx-7 md:mx-0 w-full max-w-md text-center">
            <x-slot name="title">{{ session('message.title') }}</x-slot>
            <x-slot name="description">{{ session('message.description') }}</x-slot>
            <x-slot name="button">
                <button @click="show = false" wire:click="closeNotificationModal" class="px-12 py-2 bg-warna-200/60 hover:bg-warna-200/80 active:scale-95 transition-all text-warna-50 rounded-lg">OK</button>
            </x-slot>
        </x-notification-modal>
     </div>
    @endif

    <!--sliding invoice transaction with overlay-->
    <div x-data="{ sidebarOpen: false }" class="relative">
        <!-- Toggle Button -->
        @if($transaction_type)
        <button @click="sidebarOpen = !sidebarOpen" 
            x-show="!sidebarOpen"
            x-cloak
            x-transition:enter="transition-all ease-in-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition-all ease-in-out duration-300"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            class="fixed top-24 right-0 bg-warna-400 text-white px-4 py-2 rounded-l-full hover:bg-warna-500 transition-colors z-50 xl:hidden">
            <i class="fa-solid fa-receipt text-lg"></i>
        </button>
        @endif

        <!-- Overlay -->
        <div x-show="sidebarOpen" 
             x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-warna-300/50 z-[48] xl:hidden">
        </div>

        <!-- Sliding Sidebar -->
        <div x-show="sidebarOpen" 
             x-cloak
             x-transition:enter="transition-transform ease-in-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition-transform ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed inset-y-0 right-0 w-full max-w-md bg-white shadow-lg z-[52] overflow-y-auto xl:hidden">
            
            <!-- Header -->
            <div class="sticky top-0 bg-white border-b p-6 pb-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg md:text-xl font-semibold">Detail Transaksi</h3>
                    <button @click="sidebarOpen = false" 
                            class="text-gray-600 hover:text-gray-800 transition-colors">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 pt-4">
                @if($transaction_type === 'additional_items_sale' && !empty($selectedProducts))
                    <div class="space-y-4">
                        <!-- Header Produk Terpilih -->
                        <div class="border-b pb-3">
                            <h4 class="font-semibold text-gray-800">Produk Terpilih</h4>
                        </div>
                        
                        <!-- List Produk -->
                        <div class="space-y-3">
                            @foreach($selectedProducts as $productId => $item)
                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                    <div class="flex-1 min-w-0">
                                        <h5 class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</h5>
                                        <p class="text-xs text-gray-500">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center space-x-1">
                                            <button type="button" 
                                                    wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] - 1 }})"
                                                    class="w-6 h-6 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center text-xs">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            
                                            <span class="w-8 text-center text-sm font-medium">{{ $item['quantity'] }}</span>
                                            
                                            <button type="button" 
                                                    wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] + 1 }})"
                                                    class="w-6 h-6 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center text-xs">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Remove Button -->
                                        <button type="button" 
                                                wire:click="removeProduct({{ $productId }})"
                                                class="w-6 h-6 bg-red-100 hover:bg-red-200 text-red-600 rounded-full flex items-center justify-center text-xs">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Subtotal -->
                                <div class="text-right text-sm text-gray-600 mt-1">
                                    Subtotal: Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Total -->
                        <div class="border-t pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-800">Total:</span>
                                <span class="text-lg font-bold text-warna-600">
                                    Rp {{ number_format($totalAmount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @elseif($transaction_type === 'membership_payment' && $selectedMember && $selectedMemberData)
                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <h4 class="font-semibold text-gray-800 mb-3">Ringkasan Pembayaran</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tipe:</span>
                                    <span class="font-medium">Pembayaran Membership</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Member:</span>
                                    <span class="font-medium">{{ $selectedMemberData->name }}</span>
                                </div>
                                @if($member_type || $selectedMemberData->member_type)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Jenis:</span>
                                        <span class="font-medium">{{ ucfirst($member_type ?: $selectedMemberData->member_type) }}</span>
                                    </div>
                                @endif
                                @if($duration_membership)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Durasi:</span>
                                        <span class="font-medium">{{ $durationOptions[$duration_membership] ?? $duration_membership }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if($membershipTotal > 0)
                            <div class="border-t pt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-800">Total:</span>
                                    <span class="text-lg font-bold text-warna-600">
                                        Rp {{ number_format($membershipTotal, 0, ',', '.') }}
                                    </span>
                                </div>
                                
                                <div class="mt-2 text-xs text-gray-500">
                                    <p>* Harga {{ ucfirst($member_type ?: $selectedMemberData->member_type) }} - 
                                    @switch($duration_membership)
                                        @case('one_week')
                                            1 Minggu
                                            @break
                                        @case('two_weeks')
                                            2 Minggu
                                            @break
                                        @case('three_weeks')
                                            3 Minggu
                                            @break
                                        @case('one_month')
                                            1 Bulan
                                            @break
                                    @endswitch
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                @elseif($transaction_type === 'daily_visit_fee')
                    <div class="space-y-4">
                        <div class="mb-7">
                            <h4 class="font-semibold text-gray-800 mb-3">Ringkasan Pengunjung Harian</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tipe:</span>
                                    <span class="font-medium">Pengunjung Harian</span>
                                </div>
                                @if($description)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Deskripsi:</span>
                                        <span class="font-medium">{{ $description }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="border-t pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-800">Total:</span>
                                <span class="text-lg font-bold text-warna-600">
                                    Rp {{ number_format($dailyVisitTotal, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                <p>* Tarif pengunjung harian per orang</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-receipt text-gray-400 text-3xl mb-3"></i>
                        <p class="text-gray-500">Detail transaksi akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Sliding Table Section with Overlay -->
    <div x-cloak x-data="{ showTable: false }">
        <!-- overlay -->
         <div x-show="showTable" 
            x-cloak
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="lg:hidden fixed inset-0 bg-warna-300/50 bg-opacity-50 z-[48]">
        </div>
        
        <div class="fixed lg:hidden  z-50 bottom-0 left-0 right-0 w-full bg-warna-50 border-t-2 border-warna-100 transition-transform duration-300 ease-in-out"
             :class="showTable ? 'transform translate-y-0' : 'transform translate-y-full'">
         
            <!-- Toggle Button -->
            <button @click="showTable = !showTable"
                    class="absolute -top-10 right-4 bg-warna-400 text-white px-4 py-2 rounded-t-lg hover:bg-warna-500 transition-colors">
                <i class="fa-solid fa-angle-up text-lg transition-transform duration-300" 
                :class="showTable ? 'rotate-180' : ''"></i>
            </button>


            <!-- Table Content -->
            <div class="p-4 md:p-6 max-h-96 overflow-y-auto">
                <!-- Total Transaksi Hari Ini -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-warna-700">Total Transaksi Hari Ini</h3>
                    <div class="grid grid-cols-1 gap-3">
                        <!-- Total Keseluruhan -->
                        <div class="bg-gradient-to-r from-warna-400 to-warna-500 text-white p-4 rounded-lg shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-warna-100 text-xs font-medium">Total Keseluruhan</p>
                                    <p class="text-lg font-bold">Rp {{ number_format($totalToday ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <div class="bg-white/20 p-2 rounded-full">
                                    <i class="fas fa-chart-line text-sm"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Membership & Lainnya dalam satu baris -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gradient-to-r from-blue-400 to-blue-500 text-white p-4 rounded-lg shadow">
                                <div class="text-center">
                                    <p class="text-blue-100 text-xs font-medium">Membership</p>
                                    <p class="text-sm font-bold">Rp {{ number_format($membershipToday ?? 0, 0, ',', '.') }}</p>
                                    <i class="fas fa-users text-xs mt-1"></i>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-green-400 to-green-500 text-white p-4 rounded-lg shadow">
                                <div class="text-center">
                                    <p class="text-green-100 text-xs font-medium">Produk & Harian</p>
                                    <p class="text-sm font-bold">Rp {{ number_format($otherToday ?? 0, 0, ',', '.') }}</p>
                                    <i class="fas fa-shopping-cart text-xs mt-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Transaksi -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-warna-700">Riwayat Transaksi</h3>
                        <div class="text-xs text-gray-600">
                            {{ count($todayTransactions ?? []) }} transaksi
                        </div>
                    </div>
                    
                    @forelse($todayTransactions ?? [] as $transaction)
                        <div class="bg-white border border-gray-200 rounded-lg p-3 mb-3 shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
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
                                            @endswitch
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($transaction->created_at)->format('H:i') }}
                                        </span>
                                    </div>
                                    
                                    @if($transaction->description)
                                        <p class="text-sm text-gray-600 mb-1">{{ Str::limit($transaction->description, 40) }}</p>
                                    @endif
                                    
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs
                                            {{ $transaction->payment_method === 'cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                            @if($transaction->payment_method === 'cash')
                                                <i class="fas fa-money-bill mr-1"></i>
                                                Tunai
                                            @else
                                                <i class="fas fa-qrcode mr-1"></i>
                                                QRIS
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="text-right">
                                    <p class="text-sm font-bold text-warna-600">
                                        Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-gray-300 text-2xl mb-2"></i>
                            <p class="text-gray-500 text-sm">Belum ada transaksi hari ini</p>
                            <p class="text-xs text-gray-400 mt-1">Transaksi akan muncul setelah Anda melakukan penjualan</p>
                        </div>
                    @endforelse
                    
                    @if(count($todayTransactions ?? []) > 0)
                        <div class="bg-warna-50 rounded-lg p-3 mt-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">
                                    Total {{ count($todayTransactions) }} transaksi
                                </span>
                                <span class="font-bold text-warna-600">
                                    Rp {{ number_format($totalToday ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Konfirmasi Delete -->
    @if($showDeleteModal)
    <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50">
        <div class="relative bg-white rounded-lg shadow-lg p-6 mx-7 md:mx-0 w-full max-w-md">
            <div class="text-center"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 50)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95">
                
                <!-- Icon -->
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-trash-alt text-red-600 text-xl"></i>
                </div>
                
                <!-- Title -->
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    Hapus Transaksi
                </h3>
                
                <!-- Description -->
                <p class="text-sm text-gray-500 mb-6">
                    Apakah Anda yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dibatalkan.
                </p>
                
                <!-- Buttons -->
                <div class="flex space-x-3">
                    <button 
                        wire:click="cancelDelete"
                        class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                        Batal
                    </button>
                    <button 
                        wire:click="deleteTransaction"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
