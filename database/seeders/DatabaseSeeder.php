<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Studioku',
            'email' => 'admin@studioku.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);

        \App\Models\Package::create([
            'name' => 'Basic Photobox',
            'description' => '15 Menit sesi foto, 2 cetak foto.',
            'price' => 50000,
            'duration_minutes' => 15,
        ]);

        \App\Models\Package::create([
            'name' => 'Premium Photobox',
            'description' => '30 Menit sesi foto, 4 cetak foto, semua softfile.',
            'price' => 100000,
            'duration_minutes' => 30,
        ]);
    }
}
