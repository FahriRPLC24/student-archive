<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Hanya panggil DataSeeder kita, hapus panggilan User::factory()
        $this->call([
            DataSeeder::class,
        ]);
    }
}