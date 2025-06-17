<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Dashboard extends Component
{
    #[Layout('components.layouts.dashboard')]
    public $monthlyRevenue = [];
    public $totalActive;
    public $totalPendingAdmin;
    public $thisMonth;

    public function mount()
    {
        // Ambil data pendapatan per bulan dari SQLite
        $this->totalActive = User::where('role', 'member')->where('status', 'active')->count();
        $this->totalPendingAdmin = User::where('role', 'member')->where('status', 'pending_admin_verification')->count();
        $this->thisMonth = Transaction::thisMonth()->sum('total_amount');
        $rawData = Transaction::selectRaw("strftime('%m', transaction_datetime) as month, SUM(total_amount) as total")
            ->whereRaw("strftime('%Y', transaction_datetime) = ?", [now()->format('Y')])
            ->groupByRaw("strftime('%m', transaction_datetime)")
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
