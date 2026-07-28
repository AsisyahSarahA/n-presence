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
        // Buat akun Admin default
        User::create([
            'name'     => 'Administrator',
            'username' => 'admin',
            'password' => 'admin123',
            'role'     => 'admin',
        ]);

        // Buat akun Guru Piket default
        User::create([
            'name'     => 'Guru Piket',
            'username' => 'piket',
            'password' => 'piket123',
            'role'     => 'piket',
        ]);

        // Seed default settings
        $this->call(SettingSeeder::class);
    }
}
