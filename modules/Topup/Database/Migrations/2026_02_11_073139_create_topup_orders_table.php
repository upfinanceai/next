<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('topup_orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('provider')->nullable();
            $table->string('external_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('status')->nullable();
            $table->enum('type', ['crypto', 'fiat'])->nullable();
            $table->string('currency')->nullable();
            $table->string('chain')->nullable();
            $table->decimal('amount', 18, 8)->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topup_orders');
    }
};
