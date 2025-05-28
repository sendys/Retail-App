<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@mail.com'], // Kriteria untuk mencari
            [ 
                'name' => 'Super Admin', // Ganti 'Superadmin' agar konsisten
                'password' => Hash::make('password'), // Gunakan Hash::make
            ]
        );
        $adminUser->syncRoles(['admin']); // syncRoles lebih baik untuk seeder

        $regularUser = User::firstOrCreate(
            ['email' => 'user@mail.com'],
            [
                'name' => 'Regular User', // Ganti 'User' agar lebih deskriptif
                'password' => Hash::make('password'),
            ]
        );
        $regularUser->syncRoles(['user']);

        $regularUser = User::firstOrCreate(
            ['email' => 'user1@mail.com'],
            [
                'name' => 'Regular User 1', // Ganti 'User' agar lebih deskriptif
                'password' => Hash::make('password'),
            ]
        );
        $regularUser->syncRoles(['user']);
    }
}
