<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/member', function () {
    return view('member');
});

Route::get('/pendapatan', function () {
    $pendapatanHariIni = collect([
        (object)[
            'nama' => 'Air Mineral',
            'jumlah' => 5000,
            'keterangan' => 'Pembelian air mineral oleh member untuk latihan sore',
        ],
        (object)[
            'nama' => 'Gym Harian',
            'jumlah' => 20000,
            'keterangan' => 'Pembayaran harian oleh pengunjung non-member',
        ],
        (object)[
            'nama' => 'Suplemen',
            'jumlah' => 75000,
            'keterangan' => 'Penjualan suplemen kepada member',
        ],
        (object)[
            'nama' => 'Gym Harian',
            'jumlah' => 20000,
            'keterangan' => 'Pembayaran harian oleh pengunjung kedua pagi ini',
        ],
        (object)[
            'nama' => 'Air Mineral',
            'jumlah' => 5000,
            'keterangan' => 'Pembelian air mineral oleh non-member setelah latihan',
        ],
    ]);

    // Total pendapatan hari ini
    $totalHariIni = $pendapatanHariIni->sum('jumlah');

    return view('pendapatan', compact('pendapatanHariIni', 'totalHariIni'));
});

