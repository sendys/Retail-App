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
        Schema::table('chart_of_account', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();

            // Optional: Isi UUID untuk data yang sudah ada
            \App\Models\ChartOfAccount::whereNull('uuid')->get()->each(function ($coa) {
                $coa->uuid = Str::uuid();
                $coa->save();
            });

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chart_of_account', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
