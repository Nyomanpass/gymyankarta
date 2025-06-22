<div class="">

<div class="bg-white shadow rounded-lg p-6 space-y-6">
    <h2 class="text-2xl font-bold text-gray-700">Laporan Member Gym</h2>

    <!-- Status Member -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <!-- Aktif -->
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

        <!-- Frozen -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-100">Member Frozen</p>
                    <p class="text-2xl font-bold">{{ $totalFrozen }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                    <i class="fas fa-user-clock text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Inactive -->
        <div class="bg-gradient-to-r from-red-500 to-red-400 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-red-100">Tidak Aktif</p>
                    <p class="text-2xl font-bold">{{ $totalInactive }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                    <i class="fas fa-user-slash text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Lokal -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-400 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-100">Member Lokal</p>
                    <p class="text-2xl font-bold">{{ $totalLocal }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                    <i class="fas fa-flag text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Asing -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-400 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-100">Member Asing</p>
                    <p class="text-2xl font-bold">{{ $totalForeign }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                    <i class="fas fa-globe text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Admin -->
        <div class="bg-gradient-to-r from-pink-500 to-pink-400 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-pink-100">Pending Verifikasi</p>
                    <p class="text-2xl font-bold">{{ $totalPendingAdmin }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                    <i class="fas fa-user-shield text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>



    <div class="bg-white shadow rounded-lg p-6 space-y-6 mt-10">
        <div class="flex flex-col lg:flex-row items-center justify-between mb-6">
            <h3 class="text-lg font-semibold mb-5 md:mb-0">Member Baru Bulan Ini</h3>
            <div class="flex items-center gap-4">
                <!-- Items per page selector -->
                <div class="flex flex-col lg:flex-row items-center gap-2">
                    <label class="text-sm hidden md:block text-gray-600">Show:</label>
                    <select wire:model.live="perPagememberbaru" 
                            class="text-sm border w-16 border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-warna-400 focus:border-warna-400">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                    </select>
                    <span class="text-sm hidden md:block text-gray-600">per page</span>
                </div>
                
                <div class="text-sm text-gray-600">
                    Total Member Baru: {{ $newThisMonth }}
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
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-cell">
                                    <button wire:click="sortBy('email')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Email</span>
                                      
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <button wire:click="sortBy('status')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Status</span>
                                      
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-cell">
                                    <button wire:click="sortBy('membership_expiration_date')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Expired</span>
                                        
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-cell">
                                    <button wire:click="sortBy('member_type')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Tipe</span>
                                       
                                    </button>
                                </th>
                               
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($newMembersThisMonth as $member)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-3 sm:px-6 py-4 text-sm font-medium text-gray-900">
                                        <div class="max-w-[150px] sm:max-w-none">
                                            <div class="truncate font-medium">{{ $member->name }}</div>
                                            <div class="text-xs text-gray-500 truncate">{{ $member->email }}</div>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-4 text-sm text-gray-500 table-cell">
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
                                    <td class="px-3 sm:px-6 py-4 text-sm text-gray-500 table-cell">
                                        @if($member->membership_expiration_date)
                                            <span class="{{ $member->membership_expiration_date->isPast() ? 'text-red-600 font-medium' : 'text-gray-900' }}">
                                                {{ $member->membership_expiration_date->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 sm:px-6 py-4 text-sm text-gray-500 table-cell">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs
                                            {{ $member->member_type === 'local' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            <i class="fas {{ $member->member_type === 'local' ? 'fa-home' : 'fa-globe' }} mr-1 flex-shrink-0"></i>
                                            <span class="truncate">{{ ucfirst($member->member_type) }}</span>
                                        </span>
                                    </td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 sm:px-6 py-12 text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                          
                                                <p class="font-medium mb-2">Belum ada member terdaftar</p>
                                                <p class="text-xs text-gray-400">Member yang baru mendaftar akan muncul di sini</p>
                                            
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Enhanced Pagination Section -->
             @if($newMembersThisMonth->hasPages())
                <div class="bg-gray-50 px-4 py-3 border-t">
                    <div class="flex items-center justify-between">
                        <!-- Pagination Info -->
                        <div class="text-sm text-gray-600">
                            Showing {{ $newMembersThisMonth->firstItem() }} to {{ $newMembersThisMonth->lastItem() }} 
                            of {{ $newMembersThisMonth->total() }} results
                        </div>
                        
                        <!-- Pagination Links -->
                        <div class="flex items-center space-x-2">
                            <!-- Previous Button -->
                            @if ($newMembersThisMonth->onFirstPage())
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
                            @if($newMembersThisMonth->lastPage() > 1)
                                @for($i = 1; $i <= $newMembersThisMonth->lastPage(); $i++)
                                    @if($i == $newMembersThisMonth->currentPage())
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
                            @if ($newMembersThisMonth->hasMorePages())
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
       
    </div>

    



    <!-- new member expirations -->
 <div class="bg-white shadow rounded-lg p-6 space-y-6 mt-10">
          <div class="flex flex-col lg:flex-row items-center justify-between mb-6">
            <h3 class="text-lg font-semibold mb-5 md:mb-0">Member Segera Expired (7 hari)</h3>
            <div class="flex items-center gap-4">
                <!-- Items per page selector -->
                <div class="flex items-center flex-col lg:flex-row gap-2">
                    <label class="text-sm hidden md:block text-gray-600">Show:</label>
                    <select wire:model.live="perPagbatas" 
                            class="text-sm border w-16 border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-warna-400 focus:border-warna-400">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                    </select>
                    <span class="text-sm hidden md:block text-gray-600">per page</span>
                </div>
                
                <div class="text-sm text-gray-600">
                    Total Member: {{ $expiringSoon }}
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
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-cell">
                                    <button wire:click="sortBy('email')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Email</span>
                                      
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <button wire:click="sortBy('status')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Status</span>
                                      
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-cell">
                                    <button wire:click="sortBy('membership_expiration_date')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Expired</span>
                                        
                                    </button>
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider table-cell">
                                    <button wire:click="sortBy('member_type')" 
                                            class="flex items-center gap-1 hover:text-gray-700 transition-colors">
                                        <span class="truncate">Tipe</span>
                                    </button>
                                </th>
                                
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($membersExpiringSoon as $member)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-3 sm:px-6 py-4 text-sm font-medium text-gray-900">
                                        <div class="max-w-[150px] sm:max-w-none">
                                            <div class="truncate font-medium">{{ $member->name }}</div>
                                            <div class="text-xs text-gray-500 md:ncate">{{ $member->email }}</div>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-4 text-sm text-gray-500 table-cell">
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
                                    <td class="px-3 sm:px-6 py-4 text-sm text-gray-500 table-cell">
                                        @if($member->membership_expiration_date)
                                            <span class="{{ $member->membership_expiration_date->isPast() ? 'text-red-600 font-medium' : 'text-gray-900' }}">
                                                {{ $member->membership_expiration_date->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 sm:px-6 py-4 text-sm text-gray-500 table-cell">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs
                                            {{ $member->member_type === 'local' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            <i class="fas {{ $member->member_type === 'local' ? 'fa-home' : 'fa-globe' }} mr-1 flex-shrink-0"></i>
                                            <span class="truncate">{{ ucfirst($member->member_type) }}</span>
                                        </span>
                                    </td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 sm:px-6 py-12 text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                          
                                                <p class="font-medium mb-2">Belum ada member terdaftar</p>
                                                <p class="text-xs text-gray-400">Member yang baru mendaftar akan muncul di sini</p>
                                            
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

             @if($membersExpiringSoon->hasPages())
                <div class="bg-gray-50 px-4 py-3 border-t">
                    <div class="flex items-center justify-between">
                        <!-- Pagination Info -->
                        <div class="text-sm text-gray-600">
                            Showing {{ $membersExpiringSoon->firstItem() }} to {{ $membersExpiringSoon->lastItem() }} 
                            of {{ $membersExpiringSoon->total() }} results
                        </div>
                        
                        <!-- Pagination Links -->
                        <div class="flex items-center space-x-2">
                            <!-- Previous Button -->
                            @if ($membersExpiringSoon->onFirstPage())
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
                            @if($membersExpiringSoon->lastPage() > 1)
                                @for($i = 1; $i <= $membersExpiringSoon->lastPage(); $i++)
                                    @if($i == $membersExpiringSoon->currentPage())
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
                            @if ($membersExpiringSoon->hasMorePages())
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
       
    </div>

    
        
</div>
