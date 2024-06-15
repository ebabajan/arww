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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_payable', 10, 2)->nullable();
            $table->decimal('amount_paid_1', 10, 2)->nullable();
            $table->decimal('amount_paid_2', 10, 2)->nullable();
            $table->decimal('amount_paid_3', 10, 2)->nullable();
            $table->decimal('amount_paid_4', 10, 2)->nullable();
            $table->decimal('amount_paid_5', 10, 2)->nullable();
            $table->decimal('remaining', 10, 2)->nullable();
            $table->foreignId('supply_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balances');
    }
};
