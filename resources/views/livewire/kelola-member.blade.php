<div>
    <div class="bg-white p-6 rounded-lg w-full">
        <h2 class="text-xl font-semibold mb-8 md:mb-10">Verifikasi Member</h2>
        <div class="mb-5">
            <x-g-input 
                wire:model.live="searchUnverifiedMember"
                class="w-full mb-5 md:mb-7"
                label="Cari Member"
            />
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-warna-200">
                <thead class="w-full text-xs ">
                    <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left leading-4 font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left leading-4 font-medium text-gray-500 uppercase tracking-wider">No Telepon</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-warna-100">
                    @if($members->isEmpty())
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                             @if($searchUnverifiedMember)
                                    Tidak ada member yang cocok dengan pencarian "{{ $searchUnverifiedMember }}"
                                @else
                                    Tidak ada member yang perlu diverifikasi.
                                @endif
                        </td>
                    </tr>
                    @endif
                    @foreach($members as $member)
                    <tr class=" ">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member['email'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member['nomor_telepon'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ str_replace('_', ' ', $member['status']) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <button wire:click="openVerifikasiModal({{ $member['id'] }})" class="px-6 py-2 md:py-3 bg-warna-700 rounded-xl text-sm text-white active:scale-95 hover:bg-warna-700/80 transition-all">Verifikasi</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-6 py-10 rounded-lg w-full mt-10">
        <div class="flex items-center justify-between mb-8 md:mb-10">
            <h2 class="text-xl font-semibold">Member Terverifikasi</h2>
            <button 
                wire:click="openTambahMemberModal" 
                class="px-4 py-2 bg-warna-700 text-white rounded-lg hover:bg-warna-700/80 active:scale-95 transition-all"
                data-tooltip-target="tooltip-add-member"
                data-tooltip-placement="top"
            >
                <i class="fa-solid fa-plus"></i>
            </button>
            <div id="tooltip-add-member" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Tambah Member Baru
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
        <div class="mb-5">
            <x-g-input 
                wire:model.live="searchVerifiedMember"
                class="w-full mb-5 md:mb-7"
                label="Cari Member"
            />
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-warna-200">
                {{-- Table header --}}
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expired</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                {{-- Table body --}}
                <tbody class="bg-white divide-y divide-warna-100">
                    @forelse($verifiedMembers as $member)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $member->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $member->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $member->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $member->membership_expiration_date ? $member->membership_expiration_date->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="openDetailMemberModal({{ $member->id }})" class="text-indigo-600 hover:text-indigo-900">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                @if($searchVerifiedMember)
                                    Tidak ada member yang cocok dengan pencarian "{{ $searchVerifiedMember }}"
                                @else
                                    Tidak ada member aktif yang terdaftar.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
       <div class="mt-6">
            {{ $verifiedMembers->links() }}
        </div>
    </div>




    <!--modals-->
    @if($isInputModalOpen)
        <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
            <x-input-modal class="relative bg-white rounded-lg shadow-lg p-6 mx-7 md:mx-0 w-full {{ $verifikasiMemberMode ? 'max-w-lg' : ($detailMemberMode ? 'max-w-4xl' : 'max-w-2xl') }}">
                @if($verifikasiMemberMode)
                    <x-slot name="title">Verifikasi Member</x-slot>
                    <x-slot name="subtitle" >Tentukan jenis member sebelum melakukan verifikasi.</x-slot>
                    <form wire:submit.prevent='verifyMember' class="w-full mt-8 md:mt-12">
                        <x-g-input 
                            wire:model.live="member_type"
                            type="select"
                            class="mb-5 md:mb-6"
                            label="Jenis Member"
                            :options="[
                                'local' => 'Local',
                                'foreign' => 'Foreign'
                            ]"
                        />
                        @if($member_type === 'foreign')
                            <x-g-input 
                                wireModel="durationMembership"
                                type="select"
                                class="mb-4"
                                label="Durasi Keanggotaan"
                                :options="[
                                'one_month' => 'Satu Bulan',
                                'three_weeks' => 'Tiga Minggu',
                                'two_weeks' => 'Dua Minggu',
                                'one_week' => 'Satu Minggu',
                            ]"
                            />
                        @endif
                        <div class="flex justify-end mt-8 md:mt-9">
                            <button @click="show = false"  type="button" wire:click="closeInputModal" class="px-5 py-2 bg-gray-300 hover:bg-gray-300/80 active:scale-95 transition-all text-gray-700 rounded-lg mr-2">Batal</button>
                            <button type="submit" class="px-5 py-2 bg-warna-700 hover:bg-warna-700/80 active:scale-95 transition-all text-white rounded-lg">Simpan</button>
                        </div>
                    </form>
                @elseif($TambahMemberMode)
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
                            <h3 class="md:text-lg font-semibold mb-4 text-gray-800">Informasi Member</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <div class="mb-1.5">
                                    <strong class="text-gray-600">Nama:</strong> 
                                    <span class="text-gray-900">{{ $memberDetail->name }}</span>
                                </div>
                                <div class="mb-1.5">
                                    <strong class="text-gray-600">Email:</strong> 
                                    <span class="text-gray-900">{{ $memberDetail->email }}</span>
                                </div>
                                <div class="mb-1.5">
                                    <strong class="text-gray-600">Nomor Telepon:</strong> 
                                    <span class="text-gray-900">{{ $memberDetail->nomor_telepon }}</span>
                                </div>
                                <div class="mb-1.5">
                                    <strong class="text-gray-600">Status:</strong> 
                                    <span class="px-2 py-1 text-xs rounded-full {{ $memberDetail->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($memberDetail->status) }}
                                    </span>
                                </div>
                                <div class="mb-1.5">
                                    <strong class="text-gray-600">Jenis Member:</strong> 
                                    <span class="text-gray-900">{{ ucfirst($memberDetail->member_type) }}</span>
                                </div>
                                @if($memberDetail->membership_expiration_date)
                                    <div class="mb-1.5">
                                        <strong class="text-gray-600">Tanggal Expired:</strong> 
                                        <span class="text-gray-900">{{ $memberDetail->membership_expiration_date->format('d/m/Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Kalender Absensi -->
                        <div class="border-t border-warna-100 pt-6">
                            <h3 class="md:text-lg font-semibold mb-4 text-gray-800">Kalender Absensi Member</h3>
                            
                            <!-- Filter Bulan dan Tahun -->
                            <div class="flex gap-4 mb-6">
                                <div class="flex-1">
                                    <select wire:model.live="selectedMonth" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @foreach($this->getMonthOptions() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <select wire:model.live="selectedYear" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @foreach($this->getYearOptions() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Header Hari -->
                            <div class="grid grid-cols-7 gap-1 mb-2">
                                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                                    <div class="text-center text-sm font-medium text-gray-500 py-2">
                                        {{ $day }}
                                    </div>
                                @endforeach
                            </div>

                            <!-- Kalender Grid -->
                            <div class="grid grid-cols-7 gap-1">
                                @foreach($this->getCalendarDays() as $day)
                                    <div class="relative h-10 flex items-center justify-center text-sm border border-gray-200 rounded
                                        {{ !$day['isCurrentMonth'] ? 'bg-gray-50 text-gray-400' : 'bg-white' }}
                                        {{ $day['isToday'] ? 'ring-2 ring-blue-500' : '' }}
                                        {{ $day['isAttended'] ? 'bg-green-100' : '' }}">
                                        
                                        <!-- Nomor Tanggal -->
                                        <span class="{{ $day['isAttended'] ? 'text-green-800 font-semibold' : 'text-gray-700' }}">
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
                            <div class="flex items-center gap-4 mt-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 bg-green-100 border border-green-200 rounded flex items-center justify-center">
                                        <i class="fas fa-check text-green-600 text-xs"></i>
                                    </div>
                                    <span class="text-gray-600">Hadir</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 bg-white border border-gray-200 rounded"></div>
                                    <span class="text-gray-600">Tidak Hadir</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 bg-white border-2 border-blue-500 rounded"></div>
                                    <span class="text-gray-600">Hari Ini</span>
                                </div>
                            </div>

                            <!-- Statistik Absensi -->
                            @php
                                $totalDaysInMonth = Carbon\Carbon::createFromDate($selectedYear, $selectedMonth, 1)->daysInMonth;
                                $attendedDays = count(array_filter($this->getCalendarDays(), function($day) {
                                    return $day['isCurrentMonth'] && $day['isAttended'];
                                }));
                                $attendancePercentage = $totalDaysInMonth > 0 ? round(($attendedDays / $totalDaysInMonth) * 100, 1) : 0;
                            @endphp
                            
                            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-semibold text-gray-800 mb-2">Statistik Bulan {{ $this->getMonthOptions()[$selectedMonth] }} {{ $selectedYear }}</h4>
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div>
                                        <div class="text-2xl font-bold text-green-600">{{ $attendedDays }}</div>
                                        <div class="text-sm text-gray-600">Hari Hadir</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-gray-600">{{ $totalDaysInMonth - $attendedDays }}</div>
                                        <div class="text-sm text-gray-600">Hari Tidak Hadir</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-blue-600">{{ $attendancePercentage }}%</div>
                                        <div class="text-sm text-gray-600">Persentase Hadir</div>
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
