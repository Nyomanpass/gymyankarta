<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'table_transaksi';

    protected $fillable = [
        'tanggal_transaksi',
        'tipe_pendapatan',
        'jumlah_pendapatan',
        'deskripsi',
    ];
}
