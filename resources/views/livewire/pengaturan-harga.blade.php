<div class="space-y-7">
    @php
        $priceGroups = [
            ['Kunjungan harian', 'Tarif sekali kunjungan, tanpa paket membership.', 'bg-orange-50 border-orange-200', [
                'harga_pengunjung_harian' => 'Member lokal', 'harga_pengunjung_harian_foreign' => 'Member asing',
            ]],
            ['Membership lokal', 'Harga paket berdasarkan durasi untuk member lokal.', 'bg-emerald-50 border-emerald-200', [
                'local_1_week' => '1 Minggu', 'local_2_weeks' => '2 Minggu', 'local_3_weeks' => '3 Minggu', 'local_1_month' => '1 Bulan',
            ]],
            ['Membership asing', 'Harga paket berdasarkan durasi untuk member asing.', 'bg-sky-50 border-sky-200', [
                'foreign_1_week' => '1 Minggu', 'foreign_2_weeks' => '2 Minggu', 'foreign_3_weeks' => '3 Minggu', 'foreign_1_month' => '1 Bulan',
            ]],
        ];
    @endphp
    <section class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="p-5 sm:p-7 border-b border-gray-100 flex flex-wrap justify-between gap-3 items-start">
            <div><h2 class="text-lg font-semibold">Tarif & Membership</h2><p class="text-sm text-warna-200 mt-1">Sesuaikan tarif gym, lalu simpan perubahan Anda.</p></div>
            <span class="rounded-full bg-gray-50 border border-gray-200 px-3 py-1.5 text-xs text-warna-200">Mata uang · IDR</span>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($priceGroups as [$title, $description, $accent, $fields])
                <section class="grid grid-cols-1 xl:grid-cols-[240px_minmax(0,1fr)] gap-6 p-5 sm:p-7" wire:key="price-group-{{ $loop->index }}">
                    <div><span class="inline-block border rounded-lg px-3 py-1.5 text-xs font-semibold {{ $accent }}">{{ $title }}</span><p class="mt-3 text-sm text-warna-200 leading-relaxed">{{ $description }}</p></div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-6">
                        @foreach($fields as $field => $label)
                            <div wire:key="price-field-{{ $field }}">
                                <label for="{{ $field }}" class="block text-sm font-medium mb-2">{{ $label }}</label>
                                <div class="relative"><span class="absolute left-4 inset-y-0 flex items-center text-sm text-warna-200 pointer-events-none">Rp</span><input id="{{ $field }}" type="number" min="0" step="any" inputmode="decimal" wire:model.live.debounce.300ms="{{ $field }}" class="w-full border border-gray-200 bg-gray-50/50 pl-12 pr-4 py-3 rounded-xl" @error($field) aria-invalid="true" aria-describedby="error-{{ $field }}" @enderror></div>
                                @error($field)<p id="error-{{ $field }}" class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
        <div class="p-5 sm:px-7 border-t border-gray-100 bg-gray-50/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <p class="text-xs text-warna-200 leading-relaxed">Perubahan tarif diterapkan setelah disimpan.</p>
            <button type="button" 
                wire:click="saveSettings"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed"
                wire:target="saveSettings"
                {{ ($harga_membership_per_bulan == $original_harga_membership_per_bulan && 
                    $harga_pengunjung_harian == $original_harga_pengunjung_harian && 
                    $harga_pengunjung_harian_foreign == $original_harga_pengunjung_harian_foreign && 
                    $foreign_1_week == $original_foreign_1_week && 
                    $foreign_2_weeks == $original_foreign_2_weeks && 
                    $foreign_3_weeks == $original_foreign_3_weeks && 
                    $foreign_1_month == $original_foreign_1_month &&
                    $local_1_week == $original_local_1_week && 
                    $local_2_weeks == $original_local_2_weeks && 
                    $local_3_weeks == $original_local_3_weeks && 
                    $local_1_month == $original_local_1_month) ? 'disabled' : '' }}
                class="w-full md:w-max bg-warna-400 hover:bg-warna-500 text-white font-medium py-3 px-6 rounded-lg transition duration-200 text-sm cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed active:scale-95">
                
                <span wire:loading.remove wire:target="saveSettings">Simpan Pengaturan</span>
                <span wire:loading wire:target="saveSettings">

                    Menyimpan...
                </span>
            </button>

        </div>
    </section>

    <section class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="p-5 sm:p-7 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div><h2 class="text-lg font-semibold">Katalog Produk</h2><p class="text-sm text-warna-200 mt-1">Atur harga dan ketersediaan produk yang dijual di kasir.</p></div>
            <button type="button" wire:click="toggleInputModal" class="bg-warna-400 hover:bg-warna-500 text-white text-sm font-semibold px-5 py-3 rounded-xl">Tambah Produk</button>
        </div>
        <div class="p-5 sm:p-7 grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-5">
            @forelse($products as $item)
                <article wire:key="price-product-{{ $item->id }}" class="border border-gray-200 rounded-2xl p-5 space-y-5">
                    <div class="flex items-start gap-4">
                        @if($item->image)
                            <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="h-20 w-20 shrink-0 rounded-xl object-cover bg-gray-50">
                        @else
                            <div class="h-20 w-20 shrink-0 rounded-xl bg-orange-50 text-orange-700 flex items-center justify-center text-xl font-semibold" aria-hidden="true">{{ strtoupper(substr($item->name, 0, 1)) }}</div>
                        @endif
                        <div class="min-w-0"><h3 class="text-sm font-semibold break-words">{{ $item->name }}</h3><span class="inline-block mt-2 text-xs rounded-full px-2.5 py-1 {{ $item->is_available ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">{{ $item->is_available ? 'Tersedia' : 'Nonaktif' }}</span>@if($item->description)<p class="text-xs text-warna-200 mt-2 line-clamp-2">{{ $item->description }}</p>@endif</div>
                    </div>
                    <div><label for="harga_produk_{{ $item->id }}" class="block text-xs font-medium text-warna-200 mb-2">Harga jual</label><div class="relative"><span class="absolute left-3 inset-y-0 flex items-center text-sm text-warna-200 pointer-events-none">Rp</span><input type="number" min="0" step="any" id="harga_produk_{{ $item->id }}" wire:model.live.debounce.300ms="harga_produk.{{ $item->id }}" class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl"></div>@error('harga_produk.'.$item->id)<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror</div>
                    <div class="flex gap-2"><button type="button" wire:click="updateProductPrice({{ $item->id }})" wire:loading.attr="disabled" @disabled($harga_produk[$item->id] == $original_price[$item->id]) class="flex-1 bg-warna-400 hover:bg-warna-500 text-white font-medium text-sm py-2.5 rounded-xl disabled:opacity-40">Simpan harga</button><button type="button" wire:click="resetProductPrice({{ $item->id }})" @disabled($harga_produk[$item->id] == $original_price[$item->id]) class="border border-gray-200 text-sm px-4 py-2.5 rounded-xl disabled:opacity-40">Batal</button></div>
                    <div class="border-t border-gray-100 pt-3"><button type="button" wire:click="toggleAvailableProduct({{ $item->id }})" wire:loading.attr="disabled" class="text-xs font-medium {{ $item->is_available ? 'text-warna-200 hover:text-red-600' : 'text-emerald-700' }}">{{ $item->is_available ? 'Nonaktifkan produk' : 'Aktifkan produk' }}</button></div>
                </article>
            @empty
                <div class="col-span-full text-center py-12 rounded-xl border border-dashed border-gray-200"><h3 class="text-sm font-semibold">Belum ada produk</h3><p class="text-sm text-warna-200 mt-2">Tambahkan produk pertama untuk mengatur harga jualnya.</p></div>
            @endforelse
        </div>
    </section>

    <!--modals-->
    @if($isInputModalOpen)
    <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 backdrop-blur-sm">
        <x-input-modal class="relative bg-white rounded-lg shadow-lg p-6 mx-7 md:mx-0 w-full max-w-lg">
            <x-slot name="title">Tambah Produk</x-slot>
            <x-slot name="subtitle">Tambahkan produk yang dapat dijual</x-slot>
            <form wire:submit.prevent="addProduct" class="mt-10 space-y-5">
                

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                    
                    @if ($image)
                        <div class="relative">
                            <img src="{{ $image->temporaryUrl() }}" alt="Preview Gambar Produk" class="w-full h-48 object-cover rounded-lg bg-gray-200">
                            <button type="button" wire:click="removeImage" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                                ×
                            </button>
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center cursor-pointer hover:bg-gray-100 transition duration-200" 
                             onclick="document.getElementById('image').click()">
                            <div class="text-center">
                                <i class="fas fa-image text-gray-400 text-2xl mb-2"></i>
                                <p class="text-gray-500 text-sm">Klik untuk menambah gambar produk</p>
                            </div>
                        </div>
                    @endif
                    
                    <input type="file" id="image" wire:model="image" accept="image/*" class="hidden">
                </div>

                <x-g-input
                    type="text"
                    id="name"
                    wireModel="name"
                    label="Nama Produk"
                    
                />

                <div class="relative">
                    <span class="absolute z-10 left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                    <x-g-input 
                        type="number"
                        id="price"
                        wireModel="price"
                        label="Harga Produk"
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="0"
                    />
                </div>

                <x-g-input 
                type="text"
                id="description"
                wireModel="description"
                label="Deskripsi Produk (opsional)"
                />


                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" @click="show = false" class=" bg-gray-300 hover:bg-gray-300/80 text-gray-700 font-medium px-6 py-3 rounded-lg transition duration-200 text-sm mb-4" 
                    wire:click="toggleInputModal">
                        Batal
                    </button>
                    <button class=" bg-warna-700 hover:bg-warna-700/80 text-white font-medium px-6 py-3 rounded-lg transition duration-200 text-sm  mb-4" 
                        type="submit">
                        Simpan
                    </button>
                </div>
            </form>
        </x-input-modal>
    </div>
    @endif


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
</div>
