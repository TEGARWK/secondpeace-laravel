<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan UserSeeder untuk menambahkan 1 admin & 1 pelanggan
        $this->call([
            UserSeeder::class,
        ]);
    }
}
