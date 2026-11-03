<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@epustaka.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Siswa
        User::create([
            'name' => 'Satria Rahmansyah',
            'email' => 'satria@epustaka.com',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);
    }
}