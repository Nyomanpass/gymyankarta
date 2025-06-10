<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing users to avoid duplicate email constraint issues
        User::truncate();

        User::create([
            'name' => 'Admin GymYakarta',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'nomor_telepon' => '081234567890',
            'role' => 'admin',
            'status' => 'active',
            'member_type' => 'local',
            'membership_started_date' => now(),
            'membership_expiration_date' => now()->addYears(3),
        ]);

        User::create([
            'name' => 'Member GymYakarta',
            'username' => 'member',
            'email' => 'member@member.com',
            'email_verified_at' => now(),
            'password' => Hash::make('member'),
            'nomor_telepon' => '081234567890',
            'role' => 'member',
            'status' => 'active',
            'member_type' => 'local',
            'membership_started_date' => now(),
            'membership_expiration_date' => now()->addYears(3),
        ]);
    }
}
