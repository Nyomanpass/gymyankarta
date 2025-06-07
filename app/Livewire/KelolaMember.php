<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\User;
use function Pest\Laravel\get;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class KelolaMember extends Component
{
    use WithPagination;

    #[Layout('components.layouts.dashboard')]

    //modals
    public $isInputModalOpen = false;
    public $isNotificationModalOpen = false;

    //properties
    public $selectedMemberId = null;
    public $searchUnverifiedMember = '';
    public $searchVerifiedMember = '';
    public $member_type = '';
    public $durationMembership = '';
    //properties untuk tambah member
    public $name = '';
    public $nomor_telepon = '';
    public $username = '';
    public $email = '';
    public $password = '';

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
    public $verifikasiMemberMode = false;
    public $TambahMemberMode = false;
    public $detailMemberMode = false;
    public $hapusMemberMode = false;

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

        // Query untuk unverified members (tanpa pagination)
        $members = User::members()
            ->when($this->searchUnverifiedMember, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->searchUnverifiedMember . '%')
                        ->orWhere('username', 'like', '%' . $this->searchUnverifiedMember . '%')
                        ->orWhere('email', 'like', '%' . $this->searchUnverifiedMember . '%');
                });
            })
            ->where(function ($query) {
                $query->where('status', 'pending_admin_verification')
                    ->orWhere('status', 'inactive');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Query untuk verified members (dengan pagination)
        $verifiedMembers = User::members()
            ->when($this->searchVerifiedMember, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->searchVerifiedMember . '%')
                        ->orWhere('username', 'like', '%' . $this->searchVerifiedMember . '%')
                        ->orWhere('email', 'like', '%' . $this->searchVerifiedMember . '%');
                });
            })
            ->where(function ($query) {
                $query->where('status', 'active')
                    ->orWhere('status', 'frozen');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'verifiedPage'); // 10 data per halaman

        return view('livewire.kelola-member', compact('members', 'verifiedMembers'));
    }

    public function updatedSerachVerifiedMember()
    {
        $this->resetPage('verified_members_page');
    }

    public function resetInput()
    {
        $this->selectedMemberId = null;
        $this->searchUnverifiedMember = '';
        $this->searchVerifiedMember = '';
        $this->member_type = '';
        $this->durationMembership = '';
        $this->verifikasiMemberMode = false;
        $this->TambahMemberMode = false;
        $this->DetailMemberMode = false;
        $this->HapusMemberMode = false;
        $this->resetPage('verifiedPage');
    }

    public function openVerifikasiModal($selectedMemberId)
    {
        $this->selectedMemberId = $selectedMemberId;
        $this->verifikasiMemberMode = true;
        $this->isInputModalOpen = true;
    }


    public function closeInputModal()
    {
        $this->isInputModalOpen = false;
        $this->resetInput();
    }

    public function closeNotificationModal()
    {
        $this->isNotificationModalOpen = false;
    }

    public function verifyMember()
    {
        $member = User::find($this->selectedMemberId);
        if ($member && $this->member_type == 'local') {
            $member->status = 'active';
            $member->member_type = 'local';
            $member->membership_started_date = now();
            $member->membership_expiration_date = now()->addMonth();
            $member->save();
            session()->flash('message', [
                'type' => 'success',
                'title' => 'Verifikasi Berhasil',
                'description' => 'Member berhasil diverifikasi.',
            ]);
        } elseif ($member && $this->member_type == 'foreign') {
            $member->status = 'active';
            $member->member_type = 'foreign';
            $member->membership_started_date = now();
            if ($this->durationMembership == 'one_month') {
                $member->membership_expiration_date = now()->addMonth();
            } elseif ($this->durationMembership == 'three_weeks') {
                $member->membership_expiration_date = now()->addWeeks(3);
            } elseif ($this->durationMembership == 'two_weeks') {
                $member->membership_expiration_date = now()->addWeeks(2);
            } elseif ($this->durationMembership == 'one_week') {
                $member->membership_expiration_date = now()->addWeek();
            }
            $member->save();
            session()->flash('message', [
                'type' => 'success',
                'title' => 'Verifikasi Berhasil',
                'description' => 'Member berhasil diverifikasi.',
            ]);
        }
        $this->closeInputModal();
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
            'status' => 'pending_admin_verification',
        ]);
        $member->save();


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
        $this->memberDetail = User::find($selectedMemberId);
        $this->detailMemberMode = true;
        $this->isInputModalOpen = true;

        // Set default bulan dan tahun ke bulan ini
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;

        // Load attendance data dan calendar
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


    // method absensi

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

        // Get membership dates
        $membershipStart = $this->memberDetail ? Carbon::parse($this->memberDetail['membership_started_date']) : null;
        $membershipEnd = $this->memberDetail ? Carbon::parse($this->memberDetail['membership_expiration_date']) : null;

        $this->calendarDays = [];
        $currentDate = $startOfCalendar->copy();

        // Generate 42 days (6 weeks * 7 days) untuk kalender yang konsisten
        for ($i = 0; $i < 42; $i++) {
            $isCurrentMonth = $currentDate->month == $this->selectedMonth;
            $isAttended = in_array($currentDate->format('Y-m-d'), $this->memberAttendances);

            // Check if date is within membership period
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

        // Hitung hari membership aktif dalam bulan ini
        $membershipActiveDays = count(array_filter($this->calendarDays, function ($day) {
            return $day['isCurrentMonth'] && $day['isMembershipActive'];
        }));

        $attendancePercentage = $membershipActiveDays > 0 ? round(($attendedDays / $membershipActiveDays) * 100, 1) : 0;

        $this->attendanceStats = [
            'totalDaysInMonth' => $totalDaysInMonth,
            'attendedDays' => $attendedDays,
            'notAttendedDays' => $membershipActiveDays - $attendedDays,
            'membershipActiveDays' => $membershipActiveDays,
            'attendancePercentage' => $attendancePercentage,
            'monthName' => $this->monthOptions[$this->selectedMonth],
            'year' => $this->selectedYear
        ];
    }

    public function getMonthOptions()
    {
        return collect([
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
            12 => 'Desember',
        ]);
    }

    public function getYearOptions()
    {
        $currentYear = now()->year;
        $years = [];
        for ($i = $currentYear - 5; $i <= $currentYear + 5; $i++) {
            $years[$i] = $i;
        }
        return $years;
    }


    // testing only. HAPUS METHOD INI KALO UDAH DI PRODUCTION
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
        } else {
            session()->flash('message', [
                'type' => 'error',
                'title' => 'Absensi Gagal',
                'description' => 'Member tidak ditemukan.',
            ]);
        }
        $this->loadMemberAttendances();
        $this->generateCalendarDays();
        $this->calculateAttendanceStats();
    }
}
