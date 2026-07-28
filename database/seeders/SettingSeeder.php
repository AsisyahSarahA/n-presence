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
            ['key' => 'school_name'],
            ['value' => 'SMP Negeri Nangtang', 'description' => 'Nama Sekolah']
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
