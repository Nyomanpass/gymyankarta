<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardMember extends Component
{

    //properties untuk profile user
    public $name = '';
    public $email = '';
    public $nomor_telepon = '';
    public $username = '';



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
    public $totalMembershipDays = 0; // Total hari membership untuk progress bar

    //properties untuk qr scanner
    public $showQrScanner = false;
    public $isProcessingAttendance = false;

    //properties untuk modal ganti password
    public $showChangePasswordModal = false;
    public $oldPassword = '';
    public $newPassword = '';
    public $confirmNewPassword = '';

    // properties mode
    public $isEditMode = false;


    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;
        $this->initializeOptions();
        $this->checkTodayAttendance();
        $this->loadMemberStats();
        $this->loadUserData();
        $this->checkMembershipWarningsOnce();
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

    public function checkInitialWarnings()
    {
        $warningKey = 'membership_warning_shown_' . Auth::id() . '_' . now()->format('Y-m-d');

        if (!session()->has($warningKey)) {
            $this->showMembershipWarnings();
        }
    }

    public function checkTodayAttendance()
    {
        $member = Auth::user();
        $this->isAttendedToday = Attendance::where('user_id', $member->id)
            ->whereDate('check_in_datetime', now())
            ->exists();
    }

    public function loadMemberStats()
    {
        $user = Auth::user();

        if ($user->membership_expiration_date) {
            $now = Carbon::now()->startOfDay(); // 👈 GUNAKAN startOfDay()
            $expirationDate = Carbon::parse($user->membership_expiration_date)->endOfDay(); // 👈 GUNAKAN endOfDay()

            if ($expirationDate->isFuture()) {
                // ✅ PERBAIKAN: Gunakan diffInDays dengan parameter false untuk hasil positif
                $this->sisaHariAktif = (int) $now->diffInDays($expirationDate, false); // 👈 TAMBAH +1 dan cast ke int
            } else {
                $this->sisaHariAktif = 0;
            }

            // ✅ PERBAIKAN 3: Hitung total hari membership untuk progress bar
            if ($user->membership_started_date) {
                $startDate = Carbon::parse($user->membership_started_date)->startOfDay();
                $totalMembershipDays = (int) $startDate->diffInDays($expirationDate);
                $this->totalMembershipDays = $totalMembershipDays; // 👈 TAMBAH PROPERTY INI
            } else {
                $this->totalMembershipDays = 30; // Default jika tidak ada start date
            }
        } else {
            $this->sisaHariAktif = 0;
            $this->totalMembershipDays = 0;
        }
    }

    public function loadCalendarData()
    {
        $member = Auth::user();

        $startOfMonth = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->startOfDay();
        $endOfMonth = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->endOfMonth()->endOfDay();

        // Get attendance data untuk bulan ini
        $this->memberAttendances = Attendance::where('user_id', $member->id)
            ->whereBetween('check_in_datetime', [$startOfMonth, $endOfMonth])
            ->pluck('check_in_datetime')
            ->map(function ($datetime) {
                return Carbon::parse($datetime)->format('Y-m-d');
            })
            ->toArray();

        $this->generateCalendarDays();
        $this->calculateAttendanceStats();
    }

    private function generateCalendarDays()
    {
        $member = Auth::user();

        $date = Carbon::createFromDate($this->selectedYear, $this->selectedMonth, 1);
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        $startOfCalendar = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);

        // Get membership period
        $membershipStart = $member->membership_started_date ? Carbon::parse($member->membership_started_date) : null;
        $membershipEnd = $member->membership_expiration_date ? Carbon::parse($member->membership_expiration_date) : null;

        $this->calendarDays = [];
        $currentDate = $startOfCalendar->copy();
        $today = now()->format('Y-m-d');

        // Generate 42 days (6 weeks)
        for ($i = 0; $i < 42; $i++) {
            $dateString = $currentDate->format('Y-m-d');
            $isCurrentMonth = $currentDate->month == $this->selectedMonth;
            $isToday = $dateString === $today;
            $isAttended = in_array($dateString, $this->memberAttendances);

            // Check if membership is active on this date
            $isMembershipActive = false;
            if ($membershipStart && $membershipEnd) {
                $isMembershipActive = $currentDate->between($membershipStart, $membershipEnd);
            }

            // Check if this is a past date (untuk menghitung ketidakhadiran)
            $isPastDate = $currentDate->lt(now()->startOfDay());

            $this->calendarDays[] = [
                'date' => $currentDate->copy(),
                'day' => $currentDate->day,
                'isCurrentMonth' => $isCurrentMonth,
                'isToday' => $isToday && $isCurrentMonth,
                'isAttended' => $isAttended && $isCurrentMonth,
                'isMembershipActive' => $isMembershipActive && $isCurrentMonth,
                'isPastDate' => $isPastDate, // Tambahkan ini
            ];

            $currentDate->addDay();
        }
    }

    private function calculateAttendanceStats()
    {
        $attendedDays = count(array_filter($this->calendarDays, function ($day) {
            return $day['isCurrentMonth'] &&
                $day['isAttended'] &&
                $day['isMembershipActive']; // 👈 TAMBAHKAN INI
        }));

        $membershipActiveDays = count(array_filter($this->calendarDays, function ($day) {
            return $day['isCurrentMonth'] && $day['isMembershipActive'];
        }));

        // Hitung tidak hadir (hanya saat membership aktif dan sudah lewat)
        $notAttendedDays = count(array_filter($this->calendarDays, function ($day) {
            return $day['isCurrentMonth'] &&
                $day['isMembershipActive'] &&
                !$day['isAttended'] &&
                $day['isPastDate'];
        }));

        $attendancePercentage = $membershipActiveDays > 0
            ? round(($attendedDays / $membershipActiveDays) * 100)
            : 0;

        $this->attendanceStats = [
            'attendedDays' => $attendedDays,
            'membershipActiveDays' => $membershipActiveDays,
            'notAttendedDays' => $notAttendedDays,
            'attendancePercentage' => $attendancePercentage,
            'monthName' => $this->monthOptions[$this->selectedMonth],
            'year' => $this->selectedYear,
            'isCurrentMonth' => $this->selectedYear == now()->year && $this->selectedMonth == now()->month,
            'isPastMonth' => $this->selectedYear < now()->year ||
                ($this->selectedYear == now()->year && $this->selectedMonth < now()->month)
        ];

        $this->totalHadir = $attendedDays;
        $this->totalTidakHadir = $notAttendedDays;
        $this->persentaseKehadiran = $attendancePercentage;
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

    //qr scanner methods
    public function openQrScanner()
    {
        if ($this->isAttendedToday) {
            session()->flash('message', [
                'type' => 'warning',
                'title' => 'Sudah Absen',
                'text' => 'Anda sudah melakukan absensi hari ini.'
            ]);
            return;
        }

        $this->showQrScanner = true;
    }

    public function closeQrScanner()
    {
        $this->showQrScanner = false;
    }

    public function processQrScan($qrData)
    {
        if ($this->isProcessingAttendance) {
            return;
        }

        $this->isProcessingAttendance = true;

        try {
            // Decode QR data
            $decodedData = json_decode(base64_decode($qrData), true);

            if (!$decodedData || !isset($decodedData['type']) || $decodedData['type'] !== 'attendance') {
                throw new \Exception('QR Code tidak valid untuk absensi');
            }

            // Check if QR code is still valid (not expired)
            if (isset($decodedData['expires_at']) && $decodedData['expires_at'] < time()) {
                throw new \Exception('QR Code sudah expired, silakan gunakan QR Code yang baru');
            }

            // Check if gym_id matches
            if (isset($decodedData['gym_id']) && $decodedData['gym_id'] !== config('app.gym_id', 'gymyankarta')) {
                throw new \Exception('QR Code tidak valid untuk gym ini');
            }

            $member = Auth::user();

            if ($member->status !== 'active') {
                throw new \Exception('Akun Anda berstatus ' . $member->status . '. Hanya member aktif yang dapat melakukan absen.');
            }

            // Double check if already attended today
            $existingAttendance = Attendance::where('user_id', $member->id)
                ->whereDate('check_in_datetime', now()->format('Y-m-d'))
                ->first();

            if ($existingAttendance) {
                throw new \Exception('Anda sudah melakukan absensi hari ini');
            }

            // Check if membership is active
            if (!$member->membership_expiration_date || Carbon::parse($member->membership_expiration_date)->isPast()) {
                throw new \Exception('Membership Anda sudah expired, silakan perpanjang terlebih dahulu');
            }

            // Create attendance record
            Attendance::create([
                'user_id' => $member->id,
                'check_in_datetime' => now(),
            ]);

            $this->closeQrScanner();
            $this->loadCalendarData();
            $this->loadMemberStats();

            session()->flash('message', [
                'type' => 'success',
                'title' => 'Absen Berhasil!',
                'text' => 'Terima kasih telah berolahraga hari ini. Absensi Anda telah tercatat pada ' . now()->format('H:i') . ' WITA.'
            ]);
        } catch (\Exception $e) {
            session()->flash('message', [
                'type' => 'error',
                'title' => 'Absen Gagal',
                'text' => $e->getMessage()
            ]);
        } finally {
            $this->isProcessingAttendance = false;
        }
    }

    // Edit Profile Methods
    public function loadUserData()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->nomor_telepon = $user->nomor_telepon;
        $this->username = $user->username;
    }


    public function toggleEditMode()
    {
        if ($this->isEditMode) {
            // Jika cancel edit, reload data dari database
            $this->loadUserData();
        }
        $this->isEditMode = !$this->isEditMode;

        Log::info('Edit mode toggled to: ' . ($this->isEditMode ? 'true' : 'false'));
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'nomor_telepon' => 'nullable|string|max:15',
            'username' => 'required|string|max:50|',
        ]);

        try {
            // throw exception when username is not available
            if (User::where('username', $this->username)->where('id', '!=', Auth::id())->exists()) {
                throw new \Exception('Username sudah digunakan, silakan pilih yang lain.');
            }

            // throw exception when email is not available
            if (User::where('email', $this->email)->where('id', '!=', Auth::id())->exists()) {
                throw new \Exception('Email sudah digunakan, silakan pilih yang lain.');
            }


            $user = User::find(Auth::id());
            $user->update([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'nomor_telepon' => $this->nomor_telepon,
            ]);

            $this->isEditMode = false;
        } catch (\Exception $e) {
            session()->flash('message', [
                'type' => 'error',
                'title' => 'Gagal Memperbarui Profil',
                'text' => $e->getMessage()
            ]);
            return;
        }

        session()->flash('message', [
            'type' => 'success',
            'title' => 'Profil Diperbarui',
            'text' => 'Profil Anda telah berhasil diperbarui.'
        ]);
    }


    //ganti password methods
    public function toggleChangePasswordModal()
    {
        $this->showChangePasswordModal = !$this->showChangePasswordModal;
    }

    public function changePassword()
    {
        $this->validate([
            'oldPassword' => 'required|string|min:8',
            'newPassword' => 'required|string|min:8',
            'confirmNewPassword' => 'required|string|min:8',
        ], [
            'oldPassword.required' => 'Password lama harus diisi.',
            'oldPassword.min' => 'Password lama minimal 8 karakter.',
            'newPassword.required' => 'Password baru harus diisi.',
            'newPassword.min' => 'Password baru minimal 8 karakter.',
            'confirmNewPassword.required' => 'Konfirmasi password baru harus diisi.',
            'confirmNewPassword.min' => 'Konfirmasi password baru minimal 8 karakter.',
        ]);

        $user = Auth::user();

        if (!password_verify($this->oldPassword, $user->password)) {
            session()->flash('message', [
                'type' => 'error',
                'title' => 'Gagal Mengganti Password',
                'text' => 'Password lama yang Anda masukkan salah.'
            ]);
            return;
        }

        if ($this->newPassword !== $this->confirmNewPassword) {
            session()->flash('message', [
                'type' => 'error',
                'title' => 'Gagal Mengganti Password',
                'text' => 'Konfirmasi password baru tidak cocok.'
            ]);
            return;
        }

        User::where('id', $user->id)->update([
            'password' => bcrypt($this->newPassword),
        ]);

        $this->showChangePasswordModal = false;
        session()->flash('message', [
            'type' => 'success',
            'title' => 'Password Berhasil Diganti',
            'text' => 'Password Anda telah berhasil diganti.'
        ]);
    }

    private function checkMembershipWarningsOnce()
    {
        $user = Auth::user();

        // ✅ Gunakan session key yang unik per visit
        $visitKey = 'membership_warning_visit_' . $user->id . '_' . session()->getId();

        if (session()->has($visitKey)) {
            return;
        }

        $warningShown = false;

        // 🟡 Warning untuk user FROZEN
        if ($user->status === 'frozen') {
            session()->flash('message', [
                'type' => 'warning',
                'title' => 'Akun Frozen',
                'text' => 'Membership Anda telah expired. Anda tidak dapat melakukan absen. Silakan lakukan pembayaran untuk mengaktifkan kembali.'
            ]);
            $warningShown = true;
        }
        // 🟠 Warning untuk user ACTIVE yang akan expired
        elseif ($user->membership_expiration_date && $user->status === 'active') {
            $expirationDate = Carbon::parse($user->membership_expiration_date);
            $now = Carbon::now();

            if ($expirationDate->isFuture()) {
                $daysLeft = (int) $now->diffInDays($expirationDate, false);

                if ($daysLeft <= 7 && $daysLeft > 0) {
                    session()->flash('message', [
                        'type' => 'warning',
                        'title' => 'Peringatan Membership',
                        'text' => "Membership Anda akan expired dalam {$daysLeft} hari. Segera lakukan pembayaran."
                    ]);
                    $warningShown = true;
                }
            }
        }

        // ✅ Set flag per session visit
        if ($warningShown) {
            session([$visitKey => true]);
        }
    }
}
