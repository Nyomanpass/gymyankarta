<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class PricingSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foreignSettings = [
            [
                'setting_key' => 'foreign_membership_1_week',
                'setting_value' => '570000',
                'description' => 'Harga membership foreign 1 minggu'
            ],
            [
                'setting_key' => 'foreign_membership_2_weeks',
                'setting_value' => '380000',
                'description' => 'Harga membership foreign 2 minggu'
            ],
            [
                'setting_key' => 'foreign_membership_3_weeks',
                'setting_value' => '190000',
                'description' => 'Harga membership foreign 3 minggu'
            ],
            [
                'setting_key' => 'foreign_membership_1_month',
                'setting_value' => '200000',
                'description' => 'Harga membership foreign 1 bulan'
            ],
            // ✅ TAMBAHKAN: Daily visit fee foreign
            [
                'setting_key' => 'daily_visit_fee_foreign',
                'setting_value' => '30000', // Sesuaikan dengan harga dari client
                'description' => 'Harga pengunjung harian foreign'
            ],
        ];

        foreach ($foreignSettings as $setting) {
            Setting::updateOrCreate(
                ['setting_key' => $setting['setting_key']],
                [
                    'setting_value' => $setting['setting_value'],
                    'description' => $setting['description']
                ]
            );
        }

        // Set default prices
        Setting::updateOrCreate(
            ['setting_key' => 'base_monthly_membership_fee'],
            [
                'setting_value' => '100000',
                'description' => 'Harga dasar membership bulanan lokal'
            ]
        );

        Setting::updateOrCreate(
            ['setting_key' => 'daily_visit_fee'],
            [
                'setting_value' => '15000',
                'description' => 'Harga pengunjung harian local'
            ]
        );
    }
}
