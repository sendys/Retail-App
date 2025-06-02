<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate --path=/database/migrations/2025_05_31_155110_create_chart_of_account_table.php
     */
    public function up(): void
    {
        Schema::create('chart_of_account', function (Blueprint $table) {
            $table->id();
            $table->string('account_code', 20)->unique();
            $table->string('account_name');
            $table->enum('account_type', ['asset', 'kewajiban', 'modal', 'pendapatan', 'biaya']);
            $table->decimal('account_balance', 15, 2)->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('level')->default(1);
            $table->boolean('is_active')->default(true);
            $table->enum('is_postable', ['yes', 'no'])->default('yes');
            $table->timestamps();
            $table->softDeletes();

            /* $table->foreign('parent_id')->references('id')->on('chart_of_accounts')->onDelete('cascade'); */
            $table->index(['account_name','account_code']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_of_account');
    }
};
