<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KelolaMember extends Component
{
    use WithPagination;

    #[Layout('components.layouts.dashboard')]

    //modals
    public $isInputModalOpen = false;
    public $isNotificationModalOpen = false;
    public $isEditModalOpen = false;

    //properties
    public $selectedMemberId = null;
    public $searchVerifiedMember = '';

    //properties untuk tambah member
    public $name = '';
    public $nomor_telepon = '';
    public $username = '';
    public $email = '';
    public $password = '';

    //properties untuk filter
    public $filterMemberType = '';
    public $filterStatus = '';

    // detail member
    public $memberDetail = [];
    public $memberAttendances = [];
    public $selectedMonth;
    public $selectedYear;

    //properties untuk absensi
    public $monthOptions = [];
    public $yearOptions = [];
    public $calendarDays = [];
    public $attendanceStats = [];

    //mode
    public $TambahMemberMode = false;
    public $detailMemberMode = false;
    public $hapusMemberMode = false;
    public $editMemberMode = false;

    public $verifikasiMemberMode = false;

    //properties untuk form edit
    public $editName = '';
    public $editEmail = '';
    public $editNomorTelepon = '';
    public $editUsername = '';
    public $editMemberType = '';
    public $selectedStatus = '';
    public $editPassword = '';

    //pagination propertiesw
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $updateQueryString = [
        'searchVerifiedMember' => ['except' => ''],
        'filterMemberType' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'perPege' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;
        $this->initializeOptions();
    }

    public function render()
    {
        if ($message = session('message')) {
            $this->isNotificationModalOpen = true;
        }

        $verifiedMembers = $this->getVerifiedMembersQuery();

        return view('livewire.kelola-member', compact('verifiedMembers'));
    }

    public function getVerifiedMembersQuery()
    {
        // Query untuk verified members dengan filter
        return User::members()
            ->when($this->searchVerifiedMember, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->searchVerifiedMember . '%')
                        ->orWhere('username', 'like', '%' . $this->searchVerifiedMember . '%')
                        ->orWhere('email', 'like', '%' . $this->searchVerifiedMember . '%')
                        ->orWhere('nomor_telepon', 'like', '%' . $this->searchVerifiedMember . '%');
                });
            })
            ->when($this->filterMemberType, function ($query) {
                $query->where('member_type', $this->filterMemberType);
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage, ['*'], 'page');
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    // Update methods for filter
    public function updatedSearchVerifiedMember()
    {
        $this->resetPage();
    }

    public function updatedFilterMemberType()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }


    public function resetFilters()
    {
        $this->filterMemberType = '';
        $this->filterStatus = '';
        $this->searchVerifiedMember = '';
        $this->showFilters = false;
        $this->resetPage();
    }

    // Method untuk mendapatkan count berdasarkan filter
    public function getFilterCounts()
    {
        $baseQuery = User::members();

        // Apply search if exists
        if ($this->searchVerifiedMember) {
            $baseQuery->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchVerifiedMember . '%')
                    ->orWhere('email', 'like', '%' . $this->searchVerifiedMember . '%')
                    ->orWhere('username', 'like', '%' . $this->searchVerifiedMember . '%')
                    ->orWhere('nomor_telepon', 'like', '%' . $this->searchVerifiedMember . '%');
            });
        }

        return [
            'total' => $baseQuery->count(),
            'local' => (clone $baseQuery)->where('member_type', 'local')->count(),
            'foreign' => (clone $baseQuery)->where('member_type', 'foreign')->count(),
            'active' => (clone $baseQuery)->where('status', 'active')->count(),
            'frozen' => (clone $baseQuery)->where('status', 'frozen')->count(),
            'inactive' => (clone $baseQuery)->where('status', 'inactive')->count(),
            'pending_email_verification' => (clone $baseQuery)->where('status', 'pending_email_verification')->count(),
            'pending_admin_verification' => (clone $baseQuery)->where('status', 'pending_admin_verification')->count(),
        ];
    }

    public function getPaginationInfo()
    {
        $members = $this->getVerifiedMembersQuery();

        return [
            'currentPage' => $members->currentPage(),
            'lastPage' => $members->lastPage(),
            'total' => $members->total(),
            'perPage' => $members->perPage(),
            'from' => $members->firstItem(),
            'to' => $members->lastItem(),
            'hasPages' => $members->hasPages(),
            'onFirstPage' => $members->onFirstPage(),
            'hasMorePages' => $members->hasMorePages()
        ];
    }

    public function resetInput()
    {
        $this->selectedMemberId = null;
        $this->searchVerifiedMember = '';
        $this->TambahMemberMode = false;
        $this->detailMemberMode = false;
        $this->hapusMemberMode = false;
        $this->editMemberMode = false;
        $this->resetPage('verifiedPage');

        // Reset form input untuk tambah member
        $this->name = '';
        $this->nomor_telepon = '';
        $this->username = '';
        $this->email = '';
        $this->password = '';
    }

    public function closeInputModal()
    {
        $this->isInputModalOpen = false;
        $this->resetInput();
    }


    public function closeEditModal()
    {
        $this->isEditModalOpen = false;
        $this->isInputModalOpen = true;
        $this->detailMemberMode = true;
        $this->resetEditForm();
    }

    public function closeNotificationModal()
    {
        $this->isNotificationModalOpen = false;
    }

    public function openEditMemberModal()
    {
        $this->editMemberMode = true;
        $this->detailMemberMode = false;

        $this->editName = $this->memberDetail['name'];
        $this->editEmail = $this->memberDetail['email'];
        $this->editNomorTelepon = $this->memberDetail['nomor_telepon'];
        $this->editUsername = $this->memberDetail['username'];
        $this->editMemberType = $this->memberDetail['member_type'];
        $this->selectedStatus = $this->memberDetail['status'];
        $this->editPassword = '';

        $this->isEditModalOpen = true;
    }


    public function resetEditForm()
    {
        $this->editName = '';
        $this->editEmail = '';
        $this->editNomorTelepon = '';
        $this->editUsername = '';
        $this->editMemberType = '';
        $this->selectedStatus = '';
        $this->editPassword = '';
    }

    public function updateMember()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editEmail' => 'required|email|unique:users,email,' . $this->memberDetail['id'],
            'editNomorTelepon' => 'required|string|max:20',
            'editUsername' => 'required|string|max:255|unique:users,username,' . $this->memberDetail['id'],
            'editMemberType' => 'required|in:local,foreign',
            'selectedStatus' => 'required|in:active,frozen,inactive',
        ], [
            'editName.required' => 'Nama tidak boleh kosong.',
            'editEmail.required' => 'Email tidak boleh kosong.',
            'editEmail.email' => 'Format email tidak valid.',
            'editEmail.unique' => 'Email sudah digunakan.',
            'editNomorTelepon.required' => 'Nomor telepon tidak boleh kosong.',
            'editUsername.required' => 'Username tidak boleh kosong.',
            'editUsername.unique' => 'Username sudah digunakan.',
            'editMemberType.required' => 'Jenis member tidak boleh kosong.',
            'selectedStatus.required' => 'Status tidak boleh kosong.',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'name' => $this->editName,
                'email' => $this->editEmail,
                'nomor_telepon' => $this->editNomorTelepon,
                'username' => $this->editUsername,
                'member_type' => $this->editMemberType,
                'status' => $this->selectedStatus,
            ];



            if (!empty($this->editPassword)) {
                $this->validate([
                    'editPassword' => 'required|string|min:8',
                ], [
                    'editPassword.required' => 'Password tidak boleh kosong.',
                    'editPassword.min' => 'Password harus minimal 8 karakter.',
                ]);
                $updateData['password'] = Hash::make($this->editPassword);
            }



            //seharusnya data membership_started_date & expiration_date gaakan berubah kalo admin melakukan edit profil user 
            // if ($this->selectedStatus === 'inactive') {
            //     $updateData['membership_started_date'] = null;
            //     $updateData['membership_expiration_date'] = null;
            // } elseif ($this->selectedStatus === 'active') {
            //     $updateData['membership_started_date'] = now();
            //     $updateData['membership_expiration_date'] = now()->addMonth();
            // }

            User::where('id', $this->memberDetail['id'])->update($updateData);

            // Refresh memberDetail
            $this->memberDetail = User::find($this->memberDetail['id'])->toArray();

            DB::commit();
            session()->flash('message', [
                'type' => 'success',
                'title' => 'Update Berhasil',
                'description' => 'Data member berhasil diperbarui.',
            ]);

            $this->closeEditModal();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', [
                'type' => 'error',
                'title' => 'Update Gagal',
                'description' => 'Terjadi kesalahan saat memperbarui data member: ' . $e->getMessage(),
            ]);
        }
    }

    public function changeStatus($status)
    {
        try {
            $updateData = [
                'status' => $status,
            ];

            if ($status === 'inactive') {
                $updateData['membership_started_date'] = null;
                $updateData['membership_expiration_date'] = null;
            } elseif ($status === 'active') {
                $updateData['membership_started_date'] = now();
                $updateData['membership_expiration_date'] = now()->addMonth();
            }

            User::where('id', $this->selectedMemberId)->update($updateData);

            // Refresh memberDetail
            $this->memberDetail = User::find($this->selectedMemberId)->toArray();

            session()->flash('message', [
                'type' => 'success',
                'title' => 'Status Berhasil Diubah',
                'description' => 'Status member berhasil diubah menjadi ' . $status . '.',
            ]);
        } catch (\Exception $e) {
            session()->flash('message', [
                'type' => 'error',
                'title' => 'Gagal Mengubah Status',
                'description' => 'Terjadi kesalahan saat mengubah status member: ' . $e->getMessage(),
            ]);
        }
    }

    public function openTambahMemberModal()
    {
        $this->resetInput();
        $this->TambahMemberMode = true;
        $this->isInputModalOpen = true;
    }

    public function addMember()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $member = User::create([
            'name' => $this->name,
            'nomor_telepon' => $this->nomor_telepon,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'member',
            'status' => 'active', // Langsung aktif tanpa verifikasi
            'member_type' => 'local', // Default local
            'membership_started_date' => now(),
            'membership_expiration_date' => now()->addMonth(),
        ]);

        // Create transaction for new member
        $transaction = \App\Models\Transaction::create([
            'user_id' => $member->id,
            'transaction_datetime' => now(),
            'transaction_type' => 'membership_payment',
            'description' => 'Manual pembayaran membership atas nama ' . $member->name,
            'total_amount' => \App\Models\Setting::where('setting_key', 'base_monthly_membership_fee')->value('setting_value') ?? 120000,
            'payment_method' => 'cash',

        ]);

        session()->flash('message', [
            'type' => 'success',
            'title' => 'Tambah Data Berhasil',
            'description' => 'Member berhasil ditambahkan.',
        ]);

        $this->closeInputModal();
    }

    public function initializeOptions()
    {
        $this->monthOptions = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $currentYear = now()->year;
        $this->yearOptions = [];
        for ($i = $currentYear - 2; $i <= $currentYear + 1; $i++) {
            $this->yearOptions[$i] = $i;
        }
    }

    public function openDetailMemberModal($selectedMemberId)
    {
        $this->selectedMemberId = $selectedMemberId;
        $this->memberDetail = User::find($selectedMemberId)->toArray();
        $this->detailMemberMode = true;
        $this->editMemberMode = false;
        $this->isInputModalOpen = true;

        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;

        $this->loadMemberAttendances();
        $this->generateCalendarDays();
        $this->calculateAttendanceStats();
    }

    public function openHapusMemberModal()
    {
        $this->hapusMemberMode = true;
    }

    public function deleteMember()
    {
        $member = User::find($this->selectedMemberId);
        if ($member) {
            $member->delete();
            session()->flash('message', [
                'type' => 'success',
                'title' => 'Hapus Member Berhasil',
                'description' => 'Member berhasil dihapus.',
            ]);
        }
        $this->closeHapusMemberModal();
        $this->closeInputModal();
        $this->resetInput();
    }

    public function closeHapusMemberModal()
    {
        $this->hapusMemberMode = false;
    }

    // Method absensi tetap sama...
    public function updatedSelectedMonth()
    {
        $this->loadMemberAttendances();
        $this->generateCalendarDays();
        $this->calculateAttendanceStats();
    }

    public function updatedSelectedYear()
    {
        $this->loadMemberAttendances();
        $this->generateCalendarDays();
        $this->calculateAttendanceStats();
    }

    public function loadMemberAttendances()
    {
        if (!$this->selectedMemberId) return;

        $startDate = Carbon::createFromDate($this->selectedYear, $this->selectedMonth, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $this->memberAttendances = \App\Models\Attendance::where('user_id', $this->selectedMemberId)
            ->whereBetween('check_in_datetime', [$startDate, $endDate])
            ->pluck('check_in_datetime')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();
    }

    public function generateCalendarDays()
    {
        $date = Carbon::createFromDate($this->selectedYear, $this->selectedMonth, 1);
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        $startOfCalendar = $startOfMonth->copy()->startOfWeek();

        $membershipStart = $this->memberDetail ? Carbon::parse($this->memberDetail['membership_started_date']) : null;
        $membershipEnd = $this->memberDetail ? Carbon::parse($this->memberDetail['membership_expiration_date']) : null;

        $this->calendarDays = [];
        $currentDate = $startOfCalendar->copy();

        for ($i = 0; $i < 42; $i++) {
            $isCurrentMonth = $currentDate->month == $this->selectedMonth;
            $isAttended = in_array($currentDate->format('Y-m-d'), $this->memberAttendances);

            $isMembershipActive = false;
            if ($membershipStart && $membershipEnd) {
                $isMembershipActive = $currentDate->between($membershipStart, $membershipEnd);
            }

            $this->calendarDays[] = [
                'date' => $currentDate->copy(),
                'day' => $currentDate->day,
                'isCurrentMonth' => $isCurrentMonth,
                'isAttended' => $isAttended && $isCurrentMonth,
                'isToday' => $currentDate->isToday() && $isCurrentMonth,
                'isMembershipActive' => $isMembershipActive && $isCurrentMonth,
            ];

            $currentDate->addDay();
        }
    }

    private function calculateAttendanceStats()
    {
        $totalDaysInMonth = Carbon::createFromDate($this->selectedYear, $this->selectedMonth, 1)->daysInMonth;
        $attendedDays = count(array_filter($this->calendarDays, function ($day) {
            return $day['isCurrentMonth'] && $day['isAttended'];
        }));

        $membershipActiveDays = count(array_filter($this->calendarDays, function ($day) {
            return $day['isCurrentMonth'] && $day['isMembershipActive'];
        }));

        // Hitung hari yang tidak melakukan absensi hanya sampai hari sebelum hari ini
        $today = Carbon::now();
        $notAttendedDays = count(array_filter($this->calendarDays, function ($day) use ($today) {
            return $day['isCurrentMonth'] &&
                $day['isMembershipActive'] &&
                !$day['isAttended'] &&
                $day['date']->lt($today); // hanya hitung sebelum hari ini
        }));

        $attendancePercentage = $membershipActiveDays > 0 ? round(($attendedDays / $membershipActiveDays) * 100, 1) : 0;

        $this->attendanceStats = [
            'totalDaysInMonth' => $totalDaysInMonth,
            'attendedDays' => $attendedDays,
            'notAttendedDays' => $notAttendedDays,
            'membershipActiveDays' => $membershipActiveDays,
            'attendancePercentage' => $attendancePercentage,
            'monthName' => $this->monthOptions[$this->selectedMonth],
            'year' => $this->selectedYear
        ];
    }

    // Testing method - hapus di production
    public function testAbsen()
    {
        $member = User::find($this->selectedMemberId);
        if ($member) {
            $attendance = new \App\Models\Attendance();
            $attendance->user_id = $member->id;
            $attendance->check_in_datetime = now();
            $attendance->save();

            session()->flash('message', [
                'type' => 'success',
                'title' => 'Absensi Berhasil',
                'description' => 'Member berhasil absen.',
            ]);
        }
        $this->loadMemberAttendances();
        $this->generateCalendarDays();
        $this->calculateAttendanceStats();
    }
}
