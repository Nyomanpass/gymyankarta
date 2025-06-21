<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =========================================================================
        // LANGKAH PENTING: Matikan Foreign Key Checks SEMENTARA
        // Ini memungkinkan operasi seperti truncate() pada tabel yang direferensikan
        // oleh foreign key untuk berjalan.
        // =========================================================================
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // <--- BARIS INI HARUS DITAMBAHKAN!

        $this->call([
            AdminSeeder::class,
            MemberSeeder::class,
            PricingSettingsSeeder::class,
            // Add other seeders here if needed
        ]);

        // =========================================================================
        // Setelah semua seeder selesai dijalankan, aktifkan kembali Foreign Key Checks
        // Ini penting untuk menjaga integritas database Anda setelah seeding.
        // =========================================================================
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // <--- BARIS INI HARUS DITAMBAHKAN!
    }

}
