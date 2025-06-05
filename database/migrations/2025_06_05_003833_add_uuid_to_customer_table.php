<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();

            // Optional: Isi UUID untuk data yang sudah ada
            \App\Models\Customer::whereNull('uuid')->get()->each(function ($customer) {
                $customer->uuid = Str::uuid();
                $customer->save();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): voi
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
