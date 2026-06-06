<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Package;
use App\Models\Gallery;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@studioku.com'],
            [
                'name' => 'Admin Studioku',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Seed Packages
        Package::create([
            'name' => 'Basic Photobox',
            'description' => '15 Menit sesi foto, 2 cetak foto, gratis softfile (2 selected). Cocok untuk solo atau berdua.',
            'price' => 50000,
            'duration_minutes' => 15,
            'thumbnail' => null,
            'is_active' => true,
        ]);

        Package::create([
            'name' => 'Premium Photobox',
            'description' => '30 Menit sesi foto, 4 cetak foto, gratis seluruh softfile. Cocok untuk grup kecil (3-4 orang).',
            'price' => 100000,
            'duration_minutes' => 30,
            'thumbnail' => null,
            'is_active' => true,
        ]);

        Package::create([
            'name' => 'VVIP Studio Session',
            'description' => '60 Menit sesi foto eksklusif, 8 cetak foto, seluruh softfile, dan konsultasi pose oleh fotografer.',
            'price' => 250000,
            'duration_minutes' => 60,
            'thumbnail' => null,
            'is_active' => true,
        ]);

        // Seed Galleries
        Gallery::create([
            'image_path' => 'images/gallery/sample1.jpg',
            'caption' => 'Fun graduation photobox session with friends.',
            'order' => 1,
        ]);

        Gallery::create([
            'image_path' => 'images/gallery/sample2.jpg',
            'caption' => 'Cute couple photobox pose with vintage filters.',
            'order' => 2,
        ]);

        Gallery::create([
            'image_path' => 'images/gallery/sample3.jpg',
            'caption' => 'Solo portrait with professional studio lighting.',
            'order' => 3,
        ]);

        // Seed Testimonials
        Testimonial::create([
            'customer_name' => 'Budi Santoso',
            'content' => 'Tempatnya nyaman, hasilnya tajam banget! Cetak fotonya cepat dan tidak antre lama.',
            'rating' => 5,
            'is_visible' => true,
        ]);

        Testimonial::create([
            'customer_name' => 'Siti Aminah',
            'content' => 'Sangat suka dengan paket Premium. Dapat semua softfile jadi bisa diposting di sosmed. Recommended!',
            'rating' => 5,
            'is_visible' => true,
        ]);

        Testimonial::create([
            'customer_name' => 'Rian Wijaya',
            'content' => 'Proses booking online sangat gampang tanpa ribet WA admin. Bayar pake QRIS langsung beres.',
            'rating' => 4,
            'is_visible' => true,
        ]);
    }
}
