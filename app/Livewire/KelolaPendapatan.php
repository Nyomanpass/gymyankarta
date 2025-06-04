<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Transaksi;

class KelolaPendapatan extends Component
{
    #[Layout('components.layouts.dashboard')]

    public $tanggal_transaksi = null;
    public $tipe_pendapatan = '';
    public $jumlah_pendapatan = null;
    public $deskripsi = null;
    public $total_pendapatan = null;

    public function mount()
    {
        $this->tanggal_transaksi = now()->format('Y-m-d H:i');
    }
    public function render()
    {
        $this->total_pendapatan = Transaksi::whereDate('tanggal_transaksi', now())
            ->sum('jumlah_pendapatan');
        return view('livewire.kelola-pendapatan', [
            'transaksi_hari_ini' => Transaksi::whereDate('tanggal_transaksi', now())->get(),
        ]);
    }

    public function checkLivewire()
    {
        dd('Livewire is working!');
    }

    public function save()
    {
        $this->validate([
            'tipe_pendapatan' => 'required',
            'deskripsi' => 'required',
            'jumlah_pendapatan' => 'required',
        ]);

        try {
            \App\Models\Transaksi::create([
                'tanggal_transaksi' => $this->tanggal_transaksi,
                'tipe_pendapatan' => $this->tipe_pendapatan,
                'jumlah_pendapatan' => $this->jumlah_pendapatan,
                'deskripsi' => $this->deskripsi,
            ]);

            session()->flash('message', 'Pendapatan berhasil disimpan.');
            $this->reset(['tanggal_transaksi', 'tipe_pendapatan', 'jumlah_pendapatan', 'deskripsi']);
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan pendapatan: ' . $e->getMessage());
        }
    }
}
