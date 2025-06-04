<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('table_transaksi', function (Blueprint $table) {
            $table->id();
            $table->datetime('tanggal_transaksi');
            $table->enum('tipe_pendapatan', ['pembayanan_membership', 'pengunjung_harian', 'pendapatan lainnya']);
            $table->decimal('jumlah_pendapatan', 15, 2);
            $table->string('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_transaksi');
    }
};
