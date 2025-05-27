<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Reset cached roles and permissions
        // Ini SANGAT PENTING agar perubahan langsung efektif
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Menentukan driver database untuk penanganan foreign key
        $driver = DB::connection()->getDriverName();

        // 2. Nonaktifkan foreign key checks (jika MySQL, hati-hati dengan driver lain)
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        // 3. Kosongkan tabel (GUNAKAN DENGAN HATI-HATI - INI MENGHAPUS SEMUA DATA)
        // Urutan truncate: pivot tabel dulu, baru tabel utama
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate(); // Jika ada user yang langsung diberi permission
        DB::table('role_has_permissions')->truncate();
        Permission::truncate();
        Role::truncate();
        // Opsional: Hapus user tertentu yang dibuat oleh seeder ini jika perlu di-reset juga
        // User::whereIn('email', ['admin@mail.com', 'user@mail.com'])->delete();
        // Hindari User::truncate() kecuali Anda benar-benar ingin menghapus SEMUA user.

        // 4. Definisikan izin
        $permissions = [
            'view dashboard',   // Lebih deskriptif
            'manage users',     // Izin umum untuk CRUD user
            'create users',
            'edit users',
            'delete users',     // Sudah ada 'delete user' dari Anda, ini contoh variasi
            // Tambahkan izin lain sesuai kebutuhan
            // 'create articles',
            // 'edit articles',
            // 'publish articles',
        ];

        // Buat izin (atau pastikan sudah ada)
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // 5. Buat peran (atau pastikan sudah ada)
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $roleUser = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        // $roleEditor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);

        // 6. Berikan izin ke peran
        // Admin mendapatkan semua izin yang baru saja dibuat
        $roleAdmin->syncPermissions(Permission::whereIn('name', [
            'view dashboard',
            'manage users', // Ini bisa mencakup create, edit, delete users jika Anda mau
            'create users',
            'edit users',
            'delete users',
            // tambahkan semua permission yang admin butuhkan
        ])->get());
        // Atau jika admin memang superadmin yang bisa segalanya:
        // $roleAdmin->syncPermissions(Permission::all());


        // User mendapatkan izin terbatas
        $roleUser->syncPermissions(['view dashboard']);
        // $roleEditor->syncPermissions(['view dashboard', 'create articles', 'edit articles']);

        // 7. Buat pengguna contoh dan tetapkan peran
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

        // 8. Aktifkan kembali foreign key checks (jika sebelumnya dinonaktifkan dan drivernya MySQL)
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->command->info('Roles and Permissions seeded successfully!');
        $this->command->info('Default users (admin@mail.com, user@mail.com) created/updated.');
        $this->command->warn('Default password for these users is "password". Please change it in a production environment.');
    }
}
