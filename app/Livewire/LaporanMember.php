<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use Carbon\Carbon;
use Livewire\WithPagination;

class LaporanMember extends Component
{
    use WithPagination;

    #[Layout('components.layouts.dashboard')]
    public $totalActive;
    public $totalFrozen;
    public $totalInactive;
    public $totalLocal;
    public $totalForeign;
    public $expiringSoon;
    public $newThisMonth;
    public $totalPendingAdmin;

    public $perPagememberbaru = 5;
    public $perPagbatas = 5;


    public function mount()
    {
        $today = Carbon::today();

        // Status
        $this->totalActive = User::where('role', 'member')->where('status', 'active')->count();
        $this->totalFrozen = User::where('role', 'member')->where('status', 'frozen')->count();
        $this->totalInactive = User::where('role', 'member')->where('status', 'inactive')->count();
        $this->totalPendingAdmin = User::where('role', 'member')->where('status', 'pending_admin_verification')->count();

        // Tipe member
        $this->totalLocal = User::where('role', 'member')->where('member_type', 'local')->count();
        $this->totalForeign = User::where('role', 'member')->where('member_type', 'foreign')->count();

        // Expiring soon
        $this->expiringSoon = User::where('role', 'member')
            ->whereNotNull('membership_expiration_date')
            ->whereBetween('membership_expiration_date', [$today, $today->copy()->addDays(7)])
            ->count();

        // New this month
        $this->newThisMonth = User::where('role', 'member')
            ->whereMonth('membership_started_date', now()->month)
            ->whereYear('membership_started_date', now()->year)
            ->count();
    }

    

    public function render()
    {
        $today = Carbon::today();

        $membersExpiringSoon = User::where('role', 'member')
            ->whereNotNull('membership_expiration_date')
            ->whereBetween('membership_expiration_date', [$today, $today->copy()->addDays(7)])
            ->orderBy('membership_expiration_date', 'asc')
            ->paginate($this->perPagbatas); // Gunakan paginate

        $newMembersThisMonth = User::where('role', 'member')
            ->whereMonth('membership_started_date', now()->month)
            ->whereYear('membership_started_date', now()->year)
            ->orderBy('membership_started_date', 'desc')
            ->paginate($this->perPagememberbaru); // Gunakan paginate

        return view('livewire.laporan-member', [
            'membersExpiringSoon' => $membersExpiringSoon,
            'newMembersThisMonth' => $newMembersThisMonth,
        ]);
    }
}
