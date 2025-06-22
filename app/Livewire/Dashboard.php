<?php
// app/Livewire/Dashboard.php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    #[Layout('components.layouts.dashboard')]

    // ✅ KATEGORI 1: RINGKASAN KEUANGAN
    public $todayRevenue;
    public $thisMonthRevenue;
    public $thisYearRevenue;
    public $monthlyRevenue = [];
    public $revenueByType;

    // ✅ KATEGORI 2: RINGKASAN MEMBER
    public $totalMembers;
    public $totalActive;
    public $totalFrozen;
    public $totalInactive;
    public $totalPendingAdmin;
    public $expiringSoon;
    public $membershipDistribution;

    // ✅ KATEGORI 3: RINGKASAN AKTIVITAS GYM
    public $totalVisitorsToday;  // Member absen + Daily visitors
    public $memberAttendanceToday;
    public $dailyVisitorsToday;
    public $thisWeekAttendance;

    // ✅ ADDITIONAL DATA
    public $topProducts;

    public function mount()
    {
        $this->loadFinancialSummary();
        $this->loadMemberSummary();
        $this->loadGymActivitySummary();
        $this->loadAdditionalData();
    }

    // ✅ KATEGORI 1: RINGKASAN KEUANGAN
    private function loadFinancialSummary()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        // Pendapatan hari ini
        $this->todayRevenue = Transaction::whereDate('transaction_datetime', $today)
            ->sum('total_amount');

        // Pendapatan bulan ini
        $this->thisMonthRevenue = Transaction::whereMonth('transaction_datetime', $thisMonth)
            ->whereYear('transaction_datetime', $thisYear)
            ->sum('total_amount');

        // Pendapatan tahun ini
        $this->thisYearRevenue = Transaction::whereYear('transaction_datetime', $thisYear)
            ->sum('total_amount');

        // Breakdown pendapatan bulan ini by type
        $this->revenueByType = [
            'membership' => Transaction::whereMonth('transaction_datetime', $thisMonth)
                ->whereYear('transaction_datetime', $thisYear)
                ->where('transaction_type', 'membership_payment')
                ->sum('total_amount'),
            'daily_visit' => Transaction::whereMonth('transaction_datetime', $thisMonth)
                ->whereYear('transaction_datetime', $thisYear)
                ->where('transaction_type', 'daily_visit_fee')
                ->sum('total_amount'),
            'products' => Transaction::whereMonth('transaction_datetime', $thisMonth)
                ->whereYear('transaction_datetime', $thisYear)
                ->where('transaction_type', 'additional_items_sale')
                ->sum('total_amount'),
        ];

        $this->loadMonthlyRevenue();
    }

    // ✅ KATEGORI 2: RINGKASAN MEMBER
    private function loadMemberSummary()
    {
        // Total semua member (tidak termasuk admin)
        $this->totalMembers = User::where('role', 'member')->count();

        // Member berdasarkan status
        $this->totalActive = User::where('role', 'member')->where('status', 'active')->count();
        $this->totalFrozen = User::where('role', 'member')->where('status', 'frozen')->count();
        $this->totalInactive = User::where('role', 'member')->where('status', 'inactive')->count();
        $this->totalPendingAdmin = User::where('role', 'member')->where('status', 'pending_admin_verification')->count();

        // Member yang akan expired dalam 7 hari
        $sevenDaysFromNow = Carbon::now()->addDays(7);
        $this->expiringSoon = User::where('role', 'member')
            ->where('status', 'active')
            ->whereBetween('membership_expiration_date', [Carbon::now(), $sevenDaysFromNow])
            ->count();

        // Distribusi tipe member
        $this->membershipDistribution = [
            'local' => User::where('role', 'member')->where('member_type', 'local')->count(),
            'foreign' => User::where('role', 'member')->where('member_type', 'foreign')->count(),
        ];
    }

    // ✅ KATEGORI 3: RINGKASAN AKTIVITAS GYM
    private function loadGymActivitySummary()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Absensi member hari ini
        $this->memberAttendanceToday = Attendance::whereDate('check_in_datetime', $today)->count();

        // Pengunjung harian hari ini (dari transaksi daily visit)
        $this->dailyVisitorsToday = Transaction::whereDate('transaction_datetime', $today)
            ->where('transaction_type', 'daily_visit_fee')
            ->count();

        // Total pengunjung hari ini (Member absen + Daily visitors)
        $this->totalVisitorsToday = $this->memberAttendanceToday + $this->dailyVisitorsToday;

        // Absensi minggu ini
        $this->thisWeekAttendance = Attendance::whereBetween('check_in_datetime', [$startOfWeek, $endOfWeek])
            ->count();
    }

    // ✅ DATA TAMBAHAN
    private function loadAdditionalData()
    {
        // Top 5 produk terlaris bulan ini
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        $this->topProducts = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->whereMonth('transactions.transaction_datetime', $thisMonth)
            ->whereYear('transactions.transaction_datetime', $thisYear)
            ->select('products.name', DB::raw('SUM(transaction_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
    }

    private function loadMonthlyRevenue()
    {
        // Monthly revenue chart data
        // Menggunakan YEAR() dan MONTH() untuk MySQL
        $rawData = Transaction::selectRaw("MONTH(transaction_datetime) as month, SUM(total_amount) as total")
            ->whereRaw("YEAR(transaction_datetime) = ?", [now()->format('Y')])
            ->groupByRaw("MONTH(transaction_datetime)")
            ->pluck('total', 'month')
            ->mapWithKeys(fn($value, $key) => [(int)$key => $value])
            ->toArray();

        // Isi data untuk semua bulan (1–12), jika tidak ada isi 0
        for ($i = 1; $i <= 12; $i++) {
            $this->monthlyRevenue[] = $rawData[$i] ?? 0;
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}