<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat atau perbarui akun Admin default
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name'     => 'Administrator',
                'password' => 'admin123',
                'role'     => 'admin',
            ]
        );

        // Buat atau perbarui akun Guru Piket default
        User::updateOrCreate(
            ['username' => 'piket'],
            [
                'name'     => 'Guru Piket',
                'password' => 'piket123',
                'role'     => 'piket',
            ]
        );

        // Seed default settings & real data
        $this->call(SettingSeeder::class);
        $this->call(RealDataSeeder::class);
    }
}
