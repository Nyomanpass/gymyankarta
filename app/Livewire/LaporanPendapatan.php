<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Transaction;
use Livewire\WithPagination;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;



class LaporanPendapatan extends Component
{
    use WithPagination;
    #[Layout('components.layouts.dashboard')]

    public $today, $thisMonth, $total;
    public $monthlyLabels = [];
    public $monthlyChart = [];

    public $selectedYear;
    public $selectedMonth;
    public $mountTotal = 0;

    public $perPage = 10;

    public function mount()
    {
        $this->selectedYear = now()->year;
        $this->selectedMonth = now()->month;
        $this->loadData();
        $this->calculateMountTotal();
    }

public function exportExcel()
{
    $bulanNama = date('F', mktime(0, 0, 0, $this->selectedMonth, 10)); // misal: June
    $tahun = $this->selectedYear;
    $filename = "laporanpendapatan_{$bulanNama}_{$tahun}.xlsx";

    return Excel::download(
        new TransaksiExport($this->selectedMonth, $this->selectedYear),
        $filename
    );
}





    public function updatedPerPage()
    {
        $this->resetPage();
    }

   public function updatedSelectedMonth()
    {
        $this->resetPage();
          $this->calculateMountTotal(); 
       
    }

    public function updatedSelectedYear()
    {
        $this->resetPage();
          $this->calculateMountTotal(); 
    }


    public function loadData()
    {
        $this->today = Transaction::today()->sum('total_amount');
        $this->thisMonth = Transaction::thisMonth()->sum('total_amount');
        $this->total = Transaction::sum('total_amount');   

    }

    public function render()
    {
        return view('livewire.laporan-pendapatan');

    }

   public function getTodayTransactionsProperty()
    {
        return Transaction::with(['user:id,name,email'])
            ->when($this->selectedYear, fn($q) => $q->whereYear('transaction_datetime', $this->selectedYear))
            ->when($this->selectedMonth, fn($q) => $q->whereMonth('transaction_datetime', $this->selectedMonth))
            ->orderBy('transaction_datetime', 'desc')
            ->paginate($this->perPage); // <= tambahkan ini
    }

    public function calculateMountTotal()
    {
        $this->mountTotal = Transaction::when($this->selectedYear, fn($q) => $q->whereYear('transaction_datetime', $this->selectedYear))
            ->when($this->selectedMonth, fn($q) => $q->whereMonth('transaction_datetime', $this->selectedMonth))
            ->sum('total_amount');
    }






}
