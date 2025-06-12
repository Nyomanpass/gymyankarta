<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class DashboardMember extends Component
{

    //properties untuk kalender
    public $selectedMonth = '';
    public $selectedYear = '';
    public $monthOptions = [];
    public $yearOptions = [];
    public $calendarDays = [];
    public $attendanceStats = [];
    public $memberAttendances = [];

    //properties untuk statistik
    public $totalHadir = 0;
    public $totalTidakHadir = 0;
    public $sisaHariAktif = 0;
    public $persentaseKehadiran = 0;
    public $isAttendedToday = false;


    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;
        $this->initializeOptions();
        $this->loadMemberStats();
    }

    public function render()
    {
        $this->loadCalendarData();
        return view('livewire.dashboard-member');
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
        for ($year = $currentYear - 2; $year <= $currentYear + 1; $year++) {
            $this->yearOptions[$year] = $year;
        }
    }

    public function loadMemberStats()
    {
        $member = Auth::user();

        $startOfMonth = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->startOfDay();
        $endOfMonth = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->endOfMonth()->endOfDay();


        $this->totalHadir = Attendance::where('user_id', $member->id)
            ->whereBetween('attendance_date', [$startOfMonth, $endOfMonth])
            ->count();

        $this->totalTidakHadir = Attendance::where('user_id', $member->id)
            ->whereDate('attendance_date', now()->format('Y-m-d'))
            ->exists();

        if ($member->membership_expiration_date) {
            $expirationDate = Carbon::parse($member->membership_expiration_date);
            $this->sisaHariAktif = max(0, (int) now()->diffInDays($expirationDate, false));
        } else {
            $this->sisaHariAktif = 0;
        }
    }

    public function loadCalendarData()
    {
        $member = Auth::user();

        $startOfMonth = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->startOfDay();
        $endOfMonth = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->endOfMonth()->endOfDay();

        $this->memberAttendance = Attendance::where('user_id', $member->id)
            ->whereBetween('attendance_date', [$startOfMonth, $endOfMonth])
            ->pluck('attendance_data')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();

        $this->generateCalendarDays();

        $this->calculateAttendanceStats();
    }

    private function generateCalendarDays()
    {
        $member = Auth::user();

        // Setup calendar range seperti di KelolaMember
        $date = Carbon::createFromDate($this->selectedYear, $this->selectedMonth, 1);
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        $startOfCalendar = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);

        // Get membership period dari database (sama seperti KelolaMember)
        $membershipStart = $member->membership_started_date ? Carbon::parse($member->membership_started_date) : null;
        $membershipEnd = $member->membership_expiration_date ? Carbon::parse($member->membership_expiration_date) : null;

        $this->calendarDays = [];
        $currentDate = $startOfCalendar->copy();

        // Generate 42 days (6 weeks) seperti di KelolaMember
        for ($i = 0; $i < 42; $i++) {
            $dateString = $currentDate->format('Y-m-d');
            $isCurrentMonth = $currentDate->month == $this->selectedMonth;
            $isToday = $currentDate->isToday();
            $isAttended = in_array($dateString, $this->memberAttendances);

            // Logic membership active yang sama seperti KelolaMember
            $isMembershipActive = false;
            if ($membershipStart && $membershipEnd) {
                $isMembershipActive = $currentDate->between($membershipStart, $membershipEnd);
            }

            $this->calendarDays[] = [
                'date' => $currentDate->copy(), // Tambahkan date object seperti KelolaMember
                'day' => $currentDate->day,
                'isCurrentMonth' => $isCurrentMonth,
                'isToday' => $isToday && $isCurrentMonth, // Only show today indicator for current month
                'isAttended' => $isAttended && $isCurrentMonth, // Only show attendance for current month
                'isMembershipActive' => $isMembershipActive && $isCurrentMonth, // Only show membership status for current month
            ];

            $currentDate->addDay();
        }
    }

    private function calculateAttendanceStats()
    {
        $member = Auth::user();
        $startOfMonth = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->startOfDay();
        $endOfMonth = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->endOfMonth()->endOfDay();

        $attendedDays = count(array_filter($this->calendarDays, function ($day) {
            return $day['isCurrentMonth'] && $day['isAttended'];
        }));

        $membershipActiveDays = count(array_filter($this->calendarDays, function ($day) {
            return $day['isCurrentMonth'] && $day['isMembershipActive'];
        }));

        $notAttendedDays = count(array_filter($this->calendarDays, function ($day) {
            return $day['isCurrentMonth'] && !$day['isAttended'] && !$day['isMembershipActive'];
        }));

        $attendancePersentage = $membershipActiveDays > 0
            ? round(($attendedDays / $membershipActiveDays) * 100)
            : 0;

        $this->attendanceStats = [
            'attendedDays' => $attendedDays,
            'membershipActiveDays' => $membershipActiveDays,
            'attendancePercentage' => $attendancePersentage,
            'monthName' => $this->monthOptions[$this->selectedMonth],
            'year' => $this->selectedYear,
        ];

        $this->totalHadir = $attendedDays;
        $this->totalTidakHadir = $notAttendedDays;
        $this->persentaseKehadiran = $attendancePersentage;
    }

    public function updatedSelectedMonth()
    {
        $this->loadCalendarData();
        $this->loadMemberStats();
    }

    public function updatedSelectedYear()
    {
        $this->loadCalendarData();
        $this->loadMemberStats();
    }

    // testing only
    public function testAbsen()
    {
        $member = Auth::user();

        $existingAttendance = Attendance::where('user_id', $member->id)
            ->whereDate('attendance_date', now()->format('Y-m-d'))
            ->first();

        if (!$existingAttendance) {
            Attendance::create([
                'user_id' => $member->id,
                'attendance_date' => now(),
                'attendance_data' => now()->format('Y-m-d H:i:s'),
            ]);
            session()->flash('message', [
                'type' => 'success',
                'title' => 'Absen Berhasil',
                'text' => 'Anda telah berhasil melakukan absen pada hari ini.'
            ]);
        } else {
            session()->flash('message', [
                'type' => 'error',
                'title' => 'Absen Gagal',
                'text' => 'Anda sudah melakukan absen hari ini.'
            ]);
        }

        $this->loadCalendarData();
        $this->loadMemberStats();
    }
}
