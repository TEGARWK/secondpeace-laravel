<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk membuat 1 admin dan 1 pelanggan
     */
    public function run(): void
    {
        // Admin
        User::create([
            'username' => 'admin',
            'nama' => 'Sebastian',
            'email' => 'viviwulanseptiani@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'foto_profil' => null,
        ]);

        // Pelanggan
        User::create([
            'username' => 'pino',
            'nama' => 'pino',
            'email' => 'pino@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'foto_profil' => null,
        ]);
    }
}
