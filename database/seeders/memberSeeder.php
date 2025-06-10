<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class memberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => "Member {$i}",
                'username' => "member{$i}",
                'role' => 'member',
                'status' => 'pending_admin_verification',
                'email' => "member{$i}@example.com",
                'password' => bcrypt('password'),
            ]);
        }
    }
}
