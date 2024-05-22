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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('hawala_amount');
            $table->timestamp('pickup_time')->nullable();
            $table->timestamp('rate_time')->nullable();
            $table->decimal('ex_rate_supplier', 4, 2)->nullable();
            $table->decimal('supplier_rate', 4, 2)->nullable();
            $table->decimal('amount_to_pay', 10, 2)->nullable();
            $table->decimal('exchange_rate', 4, 2)->nullable();
            $table->decimal('overheads', 10, 2)->nullable();
            $table->decimal('profit', 8, 2)->nullable();
            $table->foreignId('collector_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
