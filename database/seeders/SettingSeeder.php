<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['key' => 'app_name'],
            ['value' => 'N-Presence', 'description' => 'Nama Aplikasi']
        );

        Setting::updateOrCreate(
            ['key' => 'school_name'],
            ['value' => 'SMP Negeri Nangtang', 'description' => 'Nama Sekolah']
        );

        Setting::updateOrCreate(
            ['key' => 'app_description'],
            ['value' => 'Sistem Absensi SMP Negeri Nangtang', 'description' => 'Deskripsi / Subtitle Aplikasi']
        );

        Setting::updateOrCreate(
            ['key' => 'app_logo'],
            ['value' => '', 'description' => 'Logo Aplikasi']
        );

        Setting::updateOrCreate(
            ['key' => 'app_footer'],
            ['value' => '© 2026 KKN Kelompok 02 Nangtang. All rights reserved.', 'description' => 'Teks Footer Aplikasi']
        );

        Setting::updateOrCreate(
            ['key' => 'time_in_limit'],
            ['value' => '07:00', 'description' => 'Batas Jam Masuk']
        );

        Setting::updateOrCreate(
            ['key' => 'time_in_tolerance'],
            ['value' => '07:15', 'description' => 'Batas Toleransi Keterlambatan']
        );
    }
}
