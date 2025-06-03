<div class="w-full h-full p-6 bg-white rounded-lg">
    <div class="mx-auto w-full max-w-lg pb-10 border-b-3 border-warna-100">
        <p class="text-2xl font-semibold w-max mx-auto pb-1 mb-3 border-b-2 border-warna-200">Transaksi Hari Ini</p>
        <p class="text-3xl sm:text-4xl font-semibold text-center mx-auto px-6 py-3 rounded-lg bg-warna-700/30 text-warna-700">Rp 100.000</p>
    </div>
    <div class="mx-auto w-full max-w-lg py-5">
        <p class="font-semibold mb-8">Tambah Data Transaksi</p>
        <form wire:submit.prevent="save" class="space-y-4">
            <x-g-input 
                label="Tipe Pendapatan"
                type="select"
                name="tipe_pendapatan"
                wireModel="tipe_pendapatan"
                :options="[
                    'pembayanan_membership' => 'Pembayaran Membership',
                    'pengunjung_harian' => 'Pengunjung Harian', 
                    'pendapatan_lainnya' => 'Pendapatan Lainnya'
                ]"
                required
            />
            <x-g-input 
                label="Deskripsi"
                type="text"
                name="deskripsi"
                wireModel="deskripsi"
                required
            />
            <x-g-input 
                label="Jumlah Pendapatan"
                type="number"
                name="jumlah_pendapatan"
                wireModel="jumlah_pendapatan"
                step="0.01"
                required
            />
            
            
            <button type="submit" 
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50"
                    class="mt-4 w-full bg-warna-400 text-white font-semibold py-2 md:py-3 px-4 rounded-lg hover:bg-warna-500 transition-colors duration-200">
                <span wire:loading.remove>Simpan</span>
                <span wire:loading>Menyimpan...</span>
            </button>
        </form>


        @if (session()->has('message'))
            <div class="mt-4 p-3 bg-green-100 border-l-2 border-green-400 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif
    </div>
    
    <!-- Sliding Table Section with Overlay -->
    <div x-data="{ showTable: false }">
        <!-- overlay -->
         <div x-show="showTable" 
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="lg:hidden fixed inset-0 bg-warna-300/50 bg-opacity-50 z-[48]">
        </div>
        
        <div class="fixed z-50 bottom-0 left-0 right-0 w-full bg-warna-50 border-t-2 border-warna-100 transition-transform duration-300 ease-in-out"
             :class="showTable ? 'transform translate-y-0' : 'transform translate-y-full'">
         
        <!-- Toggle Button -->
        <button @click="showTable = !showTable" 
                class="absolute -top-10 right-4 bg-warna-400 text-white px-4 py-2 rounded-t-lg hover:bg-warna-500 transition-colors">
            <i class="fa-solid fa-angle-up text-lg transition-transform duration-300" 
               :class="showTable ? 'rotate-180' : ''"></i>
        </button>


        <!-- Table Content -->
        <div class="p-4 md:p-6 max-h-96 overflow-y-auto">
            <h3 class="text-lg font-semibold mb-5 text-warna-700">Riwayat Transaksi Hari Ini</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-warna-100">
                        <tr>
                            <th class="px-3 py-2 text-left ">Tanggal</th>
                            <th class="px-3 py-2 text-left">Tipe</th>
                            <th class="px-3 py-2 text-left">Deskripsi</th>
                            <th class="px-3 py-2 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="odd:bg-white even:bg-warna-50">
                        @foreach($transaksi_hari_ini as $item)
                            <tr class="border-b border-warna-200">
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->created_at->format('d M Y H:i') }}</td>
                                <td class="px-3 py-2 capitalize whitespace-nowrap">{{ str_replace('_', ' ', $item->tipe_pendapatan) }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->deskripsi }}</td>
                                <td class="px-3 py-2 text-right whitespace-nowrap">Rp {{ number_format($item->jumlah_pendapatan, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
