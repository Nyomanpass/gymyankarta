<div class=" w-full min-w-0">

    <div class="bg-white rounded-lg text-sm w-full min-w-0">
        <div class="p-4 sm:p-6">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Kelola Member</h2>
                <button 
                    wire:click="openTambahMemberModal" 
                    class="px-4 py-2 bg-warna-700 text-white rounded-lg hover:bg-warna-700/80 active:scale-95 transition-all flex items-center justify-center gap-2 text-sm sm:text-base">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Member</span>
                </button>
            </div>

            <!-- Search, Filter, and Per Page Section -->
            <div class="mb-6 space-y-4">
                <!-- Search Bar -->
                <div class="w-full">
                    <x-g-input 
                        wire:model.live.debounce.300ms="searchVerifiedMember"
                        class="w-full"
                        label="Cari Member"
                        placeholder="Cari berdasarkan nama, email, username, atau nomor telepon..."
                    />
                </div>

                <!-- Controls Row -->
                <div class="flex flex-col lg:flex-row items-start lg:items-end justify-between gap-4">
                    <!-- Left Side - Per Page & Filter -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-end gap-3 w-full lg:w-auto">
                        <!-- Per Page Selector -->
                        <div class="w-full sm:w-auto min-w-0">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Per Halaman</label>
                            <select wire:model.live="perPage" 
                                    class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        
                        <!-- Filter Dropdown -->
                        <div class="relative w-full sm:w-auto">
                            <button id="filterDropdownButton" 
                                    data-dropdown-toggle="filterDropdown" 
                                    data-dropdown-placement="bottom-start"
                                    class="w-full sm:w-auto px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 min-h-[42px]
                                    {{ $filterMemberType || $filterStatus ? 'bg-blue-100 text-blue-700 border border-blue-200' : '' }}"
                                    type="button">
                                <i class="fas fa-filter text-sm"></i>
                                <span>Filter</span>
                                @if($filterMemberType || $filterStatus)
                                    <span class="bg-blue-500 text-white text-xs rounded-full px-2 py-0.5 ml-1 min-w-[20px] text-center">
                                        {{ ($filterMemberType ? 1 : 0) + ($filterStatus ? 1 : 0) }}
                                    </span>
                                @endif
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="filterDropdown" class="z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-80 max-w-[90vw] border border-gray-200">
                                <div class="p-4">
                                    <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center">
                                        <i class="fas fa-filter mr-2 text-blue-600"></i>
                                        Filter Member
                                    </h3>
                                    
                                    <div class="space-y-4">
                                        <!-- Filter Jenis Member -->
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Member</label>
                                            <select wire:model.live="filterMemberType" 
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                <option value="">Semua Jenis</option>
                                                <option value="local">Local ({{ $this->getFilterCounts()['local'] }})</option>
                                                <option value="foreign">Foreign ({{ $this->getFilterCounts()['foreign'] }})</option>
                                            </select>
                                        </div>

                                        <!-- Filter Status -->
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Status Member</label>
                                            <select wire:model.live="filterStatus" 
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                <option value="">Semua Status</option>
                                                <option value="active">Active ({{ $this->getFilterCounts()['active'] }})</option>
                                                <option value="frozen">Frozen ({{ $this->getFilterCounts()['frozen'] }})</option>
                                                <option value="inactive">Inactive ({{ $this->getFilterCounts()['inactive'] }})</option>
                                                <option value="pending_email_verification">Pending Email ({{ $this->getFilterCounts()['pending_email_verification'] }})</option>
                                                <option value="pending_admin_verification">Pending Admin ({{ $this->getFilterCounts()['pending_admin_verification'] }})</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Filter Actions -->
                                    <div class="mt-5 pt-4 border-t border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <div class="text-sm text-gray-600">
                                                Total: <span class="font-semibold text-blue-600">{{ $this->getFilterCounts()['total'] }}</span> member
                                            </div>
                                            @if($filterMemberType || $filterStatus)
                                                <button wire:click="resetFilters" 
                                                        class="text-xs text-red-600 hover:text-red-700 font-medium px-2 py-1 rounded hover:bg-red-50 transition-colors">
                                                    <i class="fas fa-times mr-1"></i>Reset Filter
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Active Filters & Reset -->
                    <div class="flex items-center gap-2 flex-wrap w-full lg:w-auto">
                        <!-- Active Filter Tags -->
                        @if($filterMemberType)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-tag mr-1"></i>
                                {{ ucfirst($filterMemberType) }}
                                <button wire:click="$set('filterMemberType', '')" class="ml-2 hover:text-blue-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            </span>
                        @endif
                        
                        @if($filterStatus)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-circle mr-1"></i>
                                {{ str_replace('_', ' ', ucfirst($filterStatus)) }}
                                <button wire:click="$set('filterStatus', '')" class="ml-2 hover:text-green-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            </span>
                        @endif

                        <!-- Reset All Button -->
                        @if($filterMemberType || $filterStatus || $searchVerifiedMember)
                            <button wire:click="resetFilters" 
                                    class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-all duration-200 flex items-center gap-1.5 text-sm">
                                <i class="fas fa-refresh text-xs"></i>
                                <span>Reset All</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Table Section dengan Sorting -->
            <div class="w-full overflow-hidden border border-gray-200 rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <!-- Sortable Headers dengan responsive -->
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <button wire:click="sortBy('name')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Nama</span>
                                        @if($sortField === 'name')
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-600 flex-shrink-0"></i>
                                        @else
                                            <i class="fas fa-sort text-gray-400 flex-shrink-0"></i>
                                        @endif
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    <button wire:click="sortBy('email')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Email</span>
                                        @if($sortField === 'email')
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-600 flex-shrink-0"></i>
                                        @else
                                            <i class="fas fa-sort text-gray-400 flex-shrink-0"></i>
                                        @endif
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <button wire:click="sortBy('status')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Status</span>
                                        @if($sortField === 'status')
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-600 flex-shrink-0"></i>
                                        @else
                                            <i class="fas fa-sort text-gray-400 flex-shrink-0"></i>
                                        @endif
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                    <button wire:click="sortBy('membership_expiration_date')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Expired</span>
                                        @if($sortField === 'membership_expiration_date')
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-600 flex-shrink-0"></i>
                                        @else
                                            <i class="fas fa-sort text-gray-400 flex-shrink-0"></i>
                                        @endif
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    <button wire:click="sortBy('member_type')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Tipe</span>
                                        @if($sortField === 'member_type')
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-600 flex-shrink-0"></i>
                                        @else
                                            <i class="fas fa-sort text-gray-400 flex-shrink-0"></i>
                                        @endif
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($verifiedMembers as $member)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-3 sm:px-6 py-4 text-sm font-medium text-gray-900">
                                        <div class="max-w-[150px] sm:max-w-none">
                                            <div class="truncate font-medium">{{ $member->name }}</div>
                                            <div class="text-xs text-gray-500 md:hidden truncate">{{ $member->email }}</div>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-4 text-sm text-gray-500 hidden md:table-cell">
                                        <div class="max-w-[200px] truncate">{{ $member->email }}</div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $member->status === 'active' ? 'bg-green-100 text-green-800' : 
                                            ($member->status === 'frozen' ? 'bg-yellow-100 text-yellow-800' : 
                                            ($member->status === 'inactive' ? 'bg-red-100 text-red-800' :
                                            ($member->status === 'pending_email_verification' ? 'bg-orange-100 text-orange-800' : 'bg-purple-100 text-purple-800'))) }}">
                                            <span class="truncate">{{ str_replace('_', ' ', ucfirst($member->status)) }}</span>
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-6 py-4 text-sm text-gray-500 hidden lg:table-cell">
                                        @if($member->membership_expiration_date)
                                            <span class="{{ $member->membership_expiration_date->isPast() ? 'text-red-600 font-medium' : 'text-gray-900' }}">
                                                {{ $member->membership_expiration_date->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 sm:px-6 py-4 text-sm text-gray-500 hidden sm:table-cell">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs
                                            {{ $member->member_type === 'local' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            <i class="fas {{ $member->member_type === 'local' ? 'fa-home' : 'fa-globe' }} mr-1 flex-shrink-0"></i>
                                            <span class="truncate">{{ ucfirst($member->member_type) }}</span>
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-6 py-4 text-sm font-medium">
                                        <button wire:click="openDetailMemberModal({{ $member->id }})" 
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-150 text-sm">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 sm:px-6 py-12 text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                            @if($searchVerifiedMember || $filterMemberType || $filterStatus)
                                                <p class="font-medium mb-2">Tidak ada member yang sesuai dengan filter</p>
                                                <p class="text-xs text-gray-400 mb-4">Coba ubah kriteria pencarian atau filter Anda</p>
                                                <button wire:click="resetFilters" 
                                                        class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-xs hover:bg-blue-200 transition-colors">
                                                    Reset Filter
                                                </button>
                                            @else
                                                <p class="font-medium mb-2">Belum ada member terdaftar</p>
                                                <p class="text-xs text-gray-400">Member yang baru mendaftar akan muncul di sini</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Enhanced Pagination Section -->
            <div class="mt-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Pagination Info -->
                    <div class="text-sm text-gray-600 text-center sm:text-left">
                        @if($verifiedMembers->count() > 0)
                            Menampilkan {{ $verifiedMembers->firstItem() }} - {{ $verifiedMembers->lastItem() }} 
                            dari {{ $verifiedMembers->total() }} member
                            @if($searchVerifiedMember || $filterMemberType || $filterStatus)
                                <span class="text-blue-600 font-medium">(difilter)</span>
                            @endif
                        @else
                            Tidak ada data untuk ditampilkan
                        @endif
                    </div>

                    <!-- Pagination Links -->
                    <div class="flex items-center gap-1 flex-wrap justify-center">
                        @if($verifiedMembers->hasPages())
                            <!-- Previous Button -->
                            @if(!$verifiedMembers->onFirstPage())
                                <button wire:click="previousPage" 
                                        class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                            @endif

                            <!-- Page Numbers -->
                            <div class="flex items-center gap-1">
                                @php
                                    $currentPage = $verifiedMembers->currentPage();
                                    $lastPage = $verifiedMembers->lastPage();
                                    $startPage = max(1, $currentPage - 1);
                                    $endPage = min($lastPage, $currentPage + 1);
                                @endphp

                                @if($startPage > 1)
                                    <button wire:click="gotoPage(1)" 
                                            class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        1
                                    </button>
                                    @if($startPage > 2)
                                        <span class="px-2 text-gray-500 text-sm">...</span>
                                    @endif
                                @endif

                                @for($page = $startPage; $page <= $endPage; $page++)
                                    <button wire:click="gotoPage({{ $page }})" 
                                            class="px-3 py-2 text-sm rounded-lg transition-colors
                                            {{ $page === $currentPage ? 'bg-blue-600 text-white' : 'bg-white border border-gray-300 hover:bg-gray-50' }}">
                                        {{ $page }}
                                    </button>
                                @endfor

                                @if($endPage < $lastPage)
                                    @if($endPage < $lastPage - 1)
                                        <span class="px-2 text-gray-500 text-sm">...</span>
                                    @endif
                                    <button wire:click="gotoPage({{ $lastPage }})" 
                                            class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        {{ $lastPage }}
                                    </button>
                                @endif
                            </div>

                            <!-- Next Button -->
                            @if($verifiedMembers->hasMorePages())
                                <button wire:click="nextPage" 
                                        class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    




    <!--modals-->
    @if($isInputModalOpen)
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 backdrop-blur-sm">
            <x-input-modal class="relative bg-white rounded-lg shadow-lg p-6 mx-7 md:mx-0 w-full {{ ($detailMemberMode ? 'max-w-4xl' : 'max-w-2xl') }}">
                
                @if($TambahMemberMode)
                    <x-slot name="title">Tambah Member</x-slot>
                    <x-slot name="subtitle" >Silakan lengkapi informasi berikut untuk menambahkan member baru.</x-slot>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6 mt-5">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">
                                    Peringatan!
                                </h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Fitur tambah member ini hanya untuk keadaan <strong>urgent</strong>. <span class="hidden lg:inline">Untuk pendaftaran normal, silakan gunakan sistem pendaftaran online melalui website.</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form wire:submit.prevent='addMember' class="w-full mt-8 md:mt-10">
                        <div class="max-h-[35vh] overflow-y-auto pr-2">
                            <x-g-input 
                                wire:model.live="name"
                                class="mb-5 md:mb-6"
                                label="Nama Lengkap"
                            />
                            <x-g-input 
                                wire:model.live="nomor_telepon"
                                type="number"
                                class="mb-5 md:mb-6"
                                label="Nomor Telepon"
                            />
                            <x-g-input 
                                wire:model.live="email"
                                type="email"
                                class="mb-5 md:mb-6"
                                label="Email"
                            />
                            <x-g-input 
                                wire:model.live="username"
                                type="text"
                                class="mb-5 md:mb-6"
                                label="Username"
                            />
                            <x-g-input 
                                wire:model.live="password"
                                type="password"
                                class="mb-5 md:mb-6"
                                label="Password"
                            />
                            
                        </div>
                        @if($errors->any())
                            <div class="text-red-500 text-sm mt-2">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="flex justify-end mt-8 md:mt-9">
                            <button @click="show = false"  type="button" wire:click="closeInputModal" class="px-5 py-2 bg-gray-300 hover:bg-gray-300/80 active:scale-95 transition-all text-gray-700 rounded-lg mr-2">Batal</button>
                            <button type="submit" class="px-5 py-2 bg-warna-700 hover:bg-warna-700/80 active:scale-95 transition-all text-white rounded-lg">Simpan</button>
                        </div>
                    </form>
                @elseif($detailMemberMode)
                    <x-slot name="title">Detail Member</x-slot>
                    <x-slot name="subtitle">Berikut adalah detail informasi member.</x-slot>
                    
                    <div class="max-h-[60vh] overflow-y-auto py-2 mt-6">
                        <!-- Informasi Member -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="md:text-lg font-semibold text-gray-800">Informasi Member</h3>
                                <div class="flex items-center gap-2">
                                    <!-- Status Dropdown dengan semua status -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" 
                                                class="flex items-center px-3 py-1 text-xs rounded-full border
                                                {{ $memberDetail['status'] === 'active' ? 'bg-green-100 text-green-800 border-green-200' : 
                                                ($memberDetail['status'] === 'frozen' ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : 
                                                ($memberDetail['status'] === 'inactive' ? 'bg-red-100 text-red-800 border-red-200' :
                                                ($memberDetail['status'] === 'pending_email_verification' ? 'bg-orange-100 text-orange-800 border-orange-200' : 'bg-purple-100 text-purple-800 border-purple-200'))) }}
                                                hover:opacity-80 transition-opacity">
                                            {{ str_replace('_', ' ', ucfirst($memberDetail['status'])) }}
                                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                        </button>
                                        
                                        <div x-show="open" @click.away="open = false" 
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute right-0 mt-1 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                                            <div class="py-1">
                                                <button wire:click="changeStatus('active')" 
                                                        @click="open = false"
                                                        class="flex items-center w-full px-3 py-2 text-xs text-green-700 hover:bg-green-50 transition-colors">
                                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                                    Active
                                                </button>
                                                <button wire:click="changeStatus('frozen')" 
                                                        @click="open = false"
                                                        class="flex items-center w-full px-3 py-2 text-xs text-yellow-700 hover:bg-yellow-50 transition-colors">
                                                    <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                                    Frozen
                                                </button>
                                                <button wire:click="changeStatus('inactive')" 
                                                        @click="open = false"
                                                        class="flex items-center w-full px-3 py-2 text-xs text-red-700 hover:bg-red-50 transition-colors">
                                                    <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                                    Inactive
                                                </button>
                                                <button wire:click="changeStatus('pending_email_verification')" 
                                                        @click="open = false"
                                                        class="flex items-center w-full px-3 py-2 text-xs text-orange-700 hover:bg-orange-50 transition-colors">
                                                    <div class="w-2 h-2 bg-orange-500 rounded-full mr-2"></div>
                                                    Pending Email
                                                </button>
                                                <button wire:click="changeStatus('pending_admin_verification')" 
                                                        @click="open = false"
                                                        class="flex items-center w-full px-3 py-2 text-xs text-purple-700 hover:bg-purple-50 transition-colors">
                                                    <div class="w-2 h-2 bg-purple-500 rounded-full mr-2"></div>
                                                    Pending Admin
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Edit Button -->
                                    <button wire:click="openEditMemberModal" 
                                            class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded-md transition-colors">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Member details grid tetap sama -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <div class="mb-1.5">
                                    <strong class="text-gray-600">Nama:</strong> 
                                    <span class="text-gray-900">{{ $memberDetail['name'] }}</span>
                                </div>
                                <div class="mb-1.5">
                                    <strong class="text-gray-600">Email:</strong> 
                                    <span class="text-gray-900">{{ $memberDetail['email'] }}</span>
                                </div>
                                <div class="mb-1.5">
                                    <strong class="text-gray-600">Username:</strong> 
                                    <span class="text-gray-900">{{ $memberDetail['username'] }}</span>
                                </div>
                                <div class="mb-1.5">
                                    <strong class="text-gray-600">Nomor Telepon:</strong> 
                                    <span class="text-gray-900">{{ $memberDetail['nomor_telepon'] }}</span>
                                </div>
                                <div class="mb-1.5">
                                    <strong class="text-gray-600">Jenis Member:</strong> 
                                    <span class="text-gray-900">{{ ucfirst($memberDetail['member_type']) }}</span>
                                </div>
                                @if($memberDetail['membership_expiration_date'])
                                    <div class="mb-1.5">
                                        <strong class="text-gray-600">Tanggal Expired:</strong> 
                                        <span class="text-gray-900">{{ \Carbon\Carbon::parse($memberDetail['membership_expiration_date'])->format('d/m/Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Kalender Absensi -->
                        <div class="border-t border-warna-100 pt-6">
                            <h3 class="md:text-lg font-semibold mb-4 text-gray-800">Kalender Absensi Member</h3>
                            
                            <div class="flex gap-4 mb-6 px-2">
                                <div class="flex-1">
                                    <select wire:model.live="selectedMonth" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @foreach($monthOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <select wire:model.live="selectedYear" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @foreach($yearOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Header Hari -->
                            <div class="grid grid-cols-7 gap-1 mb-2">
                                @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $day)
                                    <div class="text-center text-sm font-medium text-gray-500 py-2">
                                        {{ $day }}
                                    </div>
                                @endforeach
                            </div>

                            <!-- Kalender Grid -->
                            <div class="grid grid-cols-7 gap-1">
                                @foreach($calendarDays as $day)
                                    <div class="relative h-10 flex items-center justify-center text-sm border border-gray-200 rounded
                                        {{ !$day['isCurrentMonth'] ? 'bg-gray-50 text-gray-400' : 'bg-white' }}
                                        {{ $day['isToday'] ? 'ring-2 ring-blue-500' : '' }}
                                        {{ $day['isAttended'] ? 'bg-green-100' : '' }}
                                        {{ $day['isMembershipActive'] && !$day['isAttended'] ? 'bg-blue-50 border-blue-200' : '' }}">
                                        
                                        <!-- Nomor Tanggal -->
                                        <span class="
                                            {{ $day['isAttended'] ? 'text-green-800 font-semibold' : '' }}
                                            {{ $day['isMembershipActive'] && !$day['isAttended'] ? 'text-blue-400' : '' }}
                                            {{ !$day['isMembershipActive'] && $day['isCurrentMonth'] ? 'text-gray-700' : '' }}
                                            {{ !$day['isCurrentMonth'] ? 'text-gray-400' : '' }}">
                                            {{ $day['day'] }}
                                        </span>
                                        
                                        <!-- Icon Centang untuk hari hadir -->
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

                            <!-- Keterangan -->
                            <div class="flex flex-wrap items-center gap-4 mt-4 text-sm">
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
                                    <div class="w-4 h-4 bg-white border-2 border-blue-500 rounded"></div>
                                    <span class="text-gray-600">Hari Ini</span>
                                </div>
                            </div>

                            <!-- Statistik Absensi -->
                            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-semibold text-gray-800 mb-2">Statistik Bulan {{ $attendanceStats['monthName'] }} {{ $attendanceStats['year'] }}</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                    <div>
                                        <div class="text-2xl font-bold text-green-600">{{ $attendanceStats['attendedDays'] }}</div>
                                        <div class="text-sm text-gray-600">Hari Hadir</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-blue-600">{{ $attendanceStats['membershipActiveDays'] }}</div>
                                        <div class="text-sm text-gray-600">Hari Membership</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-gray-600">{{ $attendanceStats['notAttendedDays'] }}</div>
                                        <div class="text-sm text-gray-600">Tidak Hadir</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-purple-600">{{ $attendanceStats['attendancePercentage'] }}%</div>
                                        <div class="text-sm text-gray-600">Tingkat Kehadiran</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-8 md:mt-9">
                        <button  
                            class="px-5 py-2 bg-warna-900 hover:bg-warna-900/80 active:scale-95 transition-all text-white rounded-lg mr-2"  
                            wire:click="openHapusMemberModal"
                            data-tooltip-target="tooltip-delete-member"
                            data-tooltip-placement="top"
                        >
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        <div id="tooltip-delete-member" role="tooltip" class="absolute z-70 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Hapus Member
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>

                        <!-- testing only. HAPUS KALO UDAH MASUK PRODUCTION -->
                        <button wire:click="testAbsen" class="text-xs bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                            TES ABSEN
                        </button>
                        
                        <button @click="show = false"  type="button" wire:click="closeInputModal()" class="px-5 lg:px-7 py-2 bg-gray-300 hover:bg-gray-300/80 active:scale-95 transition-all text-gray-700 rounded-lg mr-2">Tutup</button>
                    </div>
                @endif
            </x-input-modal>
        </div>
    @endif

     @if($isEditModalOpen)
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm" 
             x-data="{ show: false }" 
             x-init="$nextTick(() => show = true)"
             x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <x-input-modal class="relative bg-white rounded-xl shadow-2xl mx-4 md:mx-0 w-full max-w-3xl max-h-[90vh] p-6"
                           x-show="show"
                           x-transition:enter="transition ease-out duration-300 delay-100"
                           x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                           x-transition:enter-end="opacity-1 scale-100 translate-y-0"
                           x-transition:leave="transition ease-in duration-200"
                           x-transition:leave-start="opacity-1 scale-100 translate-y-0"
                           x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                
                <x-slot name="title">
                    Edit Member
                </x-slot>
                <x-slot name="subtitle">
                    Perbarui informasi member yang dipilih
                </x-slot>

                <div class="max-h-[50vh] overflow-y-auto mt-6">
                    <form wire:submit.prevent="updateMember">
                        <div class="space-y-6">
                            <!-- Personal Information Section -->
                            <div class="bg-white border border-gray-200 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-user mr-2 text-blue-600"></i>
                                    Informasi Pribadi
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-g-input 
                                        wire:model.live="editName"
                                        label="Nama Lengkap"
                                        class="transition-all duration-200 focus:scale-105"
                                    />
                                    
                                    <x-g-input 
                                        wire:model.live="editEmail"
                                        type="email"
                                        label="Email"
                                        class="transition-all duration-200 focus:scale-105"
                                    />
                                    
                                    <x-g-input 
                                        wire:model.live="editUsername"
                                        label="Username"
                                        class="transition-all duration-200 focus:scale-105"
                                    />
                                    
                                    <x-g-input 
                                        wire:model.live="editNomorTelepon"
                                        type="number"
                                        label="Nomor Telepon"
                                        class="transition-all duration-200 focus:scale-105"
                                    />
                                </div>
                            </div>

                            <!-- Membership Information Section -->
                            <div class="bg-white border border-gray-200 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-id-card mr-2 text-green-600"></i>
                                    Informasi Keanggotaan
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-g-input 
                                        wire:model.live="editMemberType"
                                        type="select"
                                        label="Jenis Member"
                                        :options="[
                                            'local' => 'Local',
                                            'foreign' => 'Foreign'
                                        ]"
                                        class="transition-all duration-200 focus:scale-105"
                                    />
                                    
                                    <x-g-input 
                                        wire:model.live="selectedStatus"
                                        type="select"
                                        label="Status"
                                        :options="[
                                            'active' => 'Active',
                                            'frozen' => 'Frozen',
                                            'inactive' => 'Inactive',
                                            'pending_email_verification' => 'Pending Email Verification',
                                            'pending_admin_verification' => 'Pending Admin Verification'
                                        ]"
                                        class="transition-all duration-200 focus:scale-105"
                                    />
                                </div>
                            </div>

                            <!-- Security Section -->
                            <div class="bg-white border border-gray-200 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-lock mr-2 text-red-600"></i>
                                    Keamanan
                                </h3>
                                <x-g-input 
                                    wire:model.live="editPassword"
                                    type="password"
                                    label="Password Baru"
                                    placeholder="Kosongkan jika tidak ingin mengubah password"
                                    class="transition-all duration-200 focus:scale-105"
                                />
                            </div>
                        </div>

                        <!-- Error Messages -->
                        @if($errors->any())
                            <div class="mt-6 bg-red-50 border border-red-200 rounded-xl p-4">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
                                    <div>
                                        <h4 class="text-red-800 font-medium mb-1">Terdapat kesalahan:</h4>
                                        <ul class="text-red-700 text-sm space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>• {{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Footer Actions -->
                <x-slot name="actions">
                    <div class="flex items-center justify-end w-full space-x-3">
                        <button type="button" @click="show = false; setTimeout(() => $wire.closeEditModal(), 200)" 
                                class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-all duration-200">
                            Batal
                        </button>
                        <button wire:click="updateMember" 
                                class="flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 hover:scale-105">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </x-slot>
            </x-input-modal>
        </div>
    @endif

    @if($isNotificationModalOpen)
     <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
       <x-notification-modal class="relative bg-white rounded-lg shadow-lg p-6 mx-7 md:mx-0 w-full max-w-md text-center">
            <x-slot name="title">{{ session('message.title') }}</x-slot>
            <x-slot name="description">{{ session('message.description') }}</x-slot>
            <x-slot name="button">
                <button @click="show = false" wire:click="closeNotificationModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg">OK</button>
            </x-slot>
        </x-notification-modal>
     </div>
    @endif

    @if($hapusMemberMode)
    <div class="fixed z-60 inset-0 flex items-center justify-center bg-black/50 ">
        <x-verification-modal class="relative bg-white rounded-lg shadow-lg p-6 mx-7 md:mx-0 w-full max-w-md text-center">
            <x-slot name="title">Hapus Member</x-slot>
            <x-slot name="description">Apakah Anda yakin ingin menghapus member ini? Tindakan ini tidak dapat dibatalkan.</x-slot>
            <x-slot name="button">
                <button @click="show = false" wire:click="closeHapusMemberModal" class="px-4 py-2 bg-gray-300 hover:bg-gray-300/80 active:scale-95 transition-all text-gray-700 rounded-lg mr-2">Batal</button>
                <button wire:click="deleteMember" class="px-4 py-2 bg-warna-900 hover:bg-warna-900/80 active:scale-95 transition-all text-white rounded-lg">Hapus</button>
            </x-slot>
        </x-verification-modal>
    </div>
    @endif

</div>
