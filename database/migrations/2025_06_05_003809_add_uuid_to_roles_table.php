<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate --path=/database/migrations/2025_06_05_003809_add_uuid_to_roles_table.php
     */
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();

            // Optional: Isi UUID untuk data yang sudah ada
            \App\Models\Role::whereNull('uuid')->get()->each(function ($role) {
                $role->uuid = Str::uuid();
                $role->save();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
