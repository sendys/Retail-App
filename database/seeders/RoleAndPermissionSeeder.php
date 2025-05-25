<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Nonaktifkan foreign key checks untuk truncate (opsional)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel hanya jika diperlukan (gunakan dengan hati-hati)
        Permission::truncate();
        Role::truncate();
        \DB::table('model_has_roles')->truncate(); // Bersihkan pivot peran pengguna
        \DB::table('role_has_permissions')->truncate(); // Bersihkan pivot izin peran

        // Kembalikan foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Definisikan izin
        $permissions = [
            'access dashboard',
            'delete user',
        ];

        // Buat izin
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat peran
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleUser = Role::firstOrCreate(['name' => 'user']);

        // Berikan izin ke peran admin
        $roleAdmin->givePermissionTo($permissions);

        // Berikan izin terbatas ke peran user (opsional)
        $roleUser->givePermissionTo('access dashboard');

        // Buat pengguna contoh dan tetapkan peran (opsional)
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );
        $adminUser->assignRole('admin');

        $regularUser = User::firstOrCreate(
            ['email' => 'user@mail.com'],
            [
                'name' => 'Regular User',
                'password' => bcrypt('password'),
            ]
        );
        $regularUser->assignRole('user');
        
    }
}
