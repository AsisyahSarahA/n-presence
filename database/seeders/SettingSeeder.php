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
            ['value' => 'SMPN SATU ATAP 1 CIGALONTANG', 'description' => 'Nama Sekolah']
        );

        Setting::updateOrCreate(
            ['key' => 'app_description'],
            ['value' => 'Sistem Absensi SMPN SATU ATAP 1 CIGALONTANG', 'description' => 'Deskripsi / Subtitle Aplikasi']
        );

        Setting::updateOrCreate(
            ['key' => 'app_logo'],
            ['value' => '', 'description' => 'Logo Aplikasi']
        );

        Setting::updateOrCreate(
            ['key' => 'app_footer'],
            ['value' => 'KKN 02 2026 LP3I Desa Nangtang (Manajemen Informatika)', 'description' => 'Teks Footer Aplikasi']
        );

        Setting::updateOrCreate(
            ['key' => 'time_in_limit'],
            ['value' => '07:00', 'description' => 'Batas Jam Masuk']
        );

        Setting::updateOrCreate(
            ['key' => 'time_in_tolerance'],
            ['value' => '07:15', 'description' => 'Batas Toleransi Keterlambatan']
        );

        Setting::updateOrCreate(
            ['key' => 'time_out_start'],
            ['value' => '13:00', 'description' => 'Batas Jam Mulai Scan Pulang']
        );
    }
}
