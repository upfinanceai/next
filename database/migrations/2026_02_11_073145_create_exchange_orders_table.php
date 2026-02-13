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
        Schema::create('exchange_orders', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('provider')->nullable();
            $table->string('external_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('transaction_id')->nullable();
            $table->string('from_currency')->nullable();
            $table->string('to_currency')->nullable();
            $table->decimal('from_amount', 18, 8)->nullable();
            $table->decimal('to_amount', 18, 8)->nullable();
            $table->decimal('exchange_rate', 18, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_orders');
    }
};
