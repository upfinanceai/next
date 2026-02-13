<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('type')->nullable();
            $table->string('sub_type')->nullable();
            $table->string('status')->nullable();
            $table->string('currency')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->decimal('amount', 18, 8)->nullable();
            $table->string('external_id')->nullable();
            $table->dateTime('cleared_at')->nullable();

            // exchange specific
            $table->string('from_currency')->nullable();
            $table->string('to_currency')->nullable();
            $table->decimal('from_amount', 18, 8)->nullable();
            $table->decimal('to_amount', 18, 8)->nullable();
            $table->decimal('exchange_rate', 18, 8)->nullable();

            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
