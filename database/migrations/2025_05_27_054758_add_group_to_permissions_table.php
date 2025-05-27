<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate --path=/database/migrations/2025_05_27_054758_add_group_to_permissions_table.php
     */
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
            $table->string('group')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
            $table->dropColumn('group');
        });
    }
};
