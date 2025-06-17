<?php
namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransaksiExport implements FromCollection, WithHeadings
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return Transaction::whereMonth('transaction_datetime', $this->bulan)
            ->whereYear('transaction_datetime', $this->tahun)
            ->select('transaction_datetime', 'transaction_type', 'description', 'payment_method', 'total_amount')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Waktu Transaksi',
            'Tipe',
            'Deskripsi',
            'Metode Pembayaran',
            'Jumlah',
        ];
    }
}
