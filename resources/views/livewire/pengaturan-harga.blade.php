<div>
    <div class="bg-white p-6 rounded-lg">
        <h2 class="text-xl font-semibold mb-8 md:mb-10">Pengaturan Harga Operasional</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="relative">
                    <span class="absolute z-10 left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                    <x-g-input 
                        type="number"
                        id="harga_membership_per_bulan"
                        wire:model.live="harga_membership_per_bulan"
                        label="Harga Membership per Bulan"
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="0"
                    />

                </div>
            </div>
            <div>
                <div class="relative">
                    <span class="absolute z-10 left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                    <x-g-input 
                        type="number"
                        id="harga_pengunjung_harian"
                        wire:model.live="harga_pengunjung_harian"
                        label="Harga Pengunjung Harian"
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="0"
                    />

                </div>
            </div>
            
        </div>

        <div class="mt-6 flex justify-end">
            <button type="button" 
                wire:click="saveSettings"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed"
                wire:target="saveSettings"
                {{ ($harga_membership_per_bulan == $original_harga_membership_per_bulan && $harga_pengunjung_harian == $original_harga_pengunjung_harian) ? 'disabled' : '' }}
                class="w-full md:w-max bg-warna-700 hover:bg-warna-700/80 text-white font-medium py-3 px-6 rounded-lg transition duration-200 text-sm cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed active:scale-95">
                   
                <span wire:loading.remove wire:target="saveSettings">Simpan Pengaturan</span>
                <span wire:loading wire:target="saveSettings">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Menyimpan...
                </span>
            </button>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg mt-10">
        <h2 class="text-xl font-semibold mb-8 md:mb-10">Pengaturan Harga Produk</h2>
        <div class="grid grid-cols-1 sm:mx-5 md:mx-0 md:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($products as $item)
                <div class="aspect-square  md:aspect-4/5 xl:aspect-auto bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200 flex flex-col">
                    <div class="relative mb-2 flex-shrink-0">
                        @if($item->is_available == false)
                            <div class="absolute inset-0 bg-warna-300/50 rounded-lg  flex items-center justify-center text-warna-50 font-medium text-sm text-center ">Barang dinonaktifkan</div>
                        @endif
                        <img src="/storage/{{ $item->image }}" alt="Gambar {{ $item->name }}" class="w-full h-20 sm:h-32 md:h-25 lg:h-24 object-cover rounded-lg bg-gray-200">
                        <div class="absolute top-1 right-1">
                            <button type="button" 
                                    wire:click="toggleAvailableProduct({{ $item->id }})"
                                    class="{{ $item->is_available ? 'bg-warna-900 hover:bg-warna-900/80' : 'bg-warna-700 hover:bg-warna-700/80' }} text-white text-xs px-1.5 py-1 rounded-full transition duration-200"
                                    title="{{ $item->is_available ? 'Nonaktifkan Produk' : 'Aktifkan Produk' }}">
                                <i class="fas {{ $item->is_available ? 'fa-times' : 'fa-check' }} text-xs"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex-1 flex flex-col justify-between min-h-0">
                        <div>
                            <h3 class="text-xs md:text-sm font-semibold text-gray-800 mb-1 line-clamp-2">{{ $item->name }}</h3>
                            
                            @if($item->description)
                                <p class="text-xs text-gray-500 mb-2 line-clamp-1">{{ $item->description }}</p>
                            @endif
                        </div>
                        
                        <div class="space-y-2">
                            <div class="relative">
                                <span class="absolute z-10 left-2 top-1/2 transform -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                <input 
                                    type="number"
                                    id="harga_produk_{{ $item->id }}"
                                    wire:model.live="harga_produk.{{ $item->id }}"
                                    class="w-full pl-8 pr-2 py-1.5 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="0"
                                    min="0"
                                />
                            </div>
                            
                            {{-- Tombol Simpan (muncul jika ada perubahan) --}}
                                <div class="flex gap-1">
                                    <button type="button"
                                            {{ $harga_produk[$item->id] != $item->price ? '' : 'disabled' }}
                                            wire:click="updateProductPrice({{ $item->id }})"
                                            class="flex-1 bg-warna-700 hover:bg-warna-700/80 text-white text-xs font-medium py-2 px-2 rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <i class="fas fa-save mr-1"></i>
                                        Simpan
                                    </button>
                                    <button type="button" 
                                            {{ $harga_produk[$item->id] == $item->price ? 'disabled' : '' }}
                                            wire:click="resetProductPrice({{ $item->id }})"
                                            class="bg-gray-400 hover:bg-gray-500 text-white text-xs font-medium py-1.5 px-2 rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                            title="Reset ke harga asli">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-gray-50 border border-dashed border-gray-300  aspect-square h-auto flex items-center justify-center">
                    <p class="text-gray-500">Tidak ada produk</p>
                </div>
            @endforelse
            <div class="aspect-square  md:aspect-4/5 xl:aspect-auto bg-gray-50 p-4 rounded-lg border flex items-center justify-center group hover:bg-gray-100 transition duration-200 active:scale-95 cursor-pointer">
                <button type="button" 
                        wire:click="toggleInputModal"
                        class="text-gray-500 hover:text-gray-700 transition duration-200 text-sm md:text-base w-full h-full">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Produk</span>
                        </div>
                </button>
            </div>
        </div>
    </div>

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
