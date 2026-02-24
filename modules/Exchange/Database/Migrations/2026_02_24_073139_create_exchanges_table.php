<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()->index();
            $table->string('provider')->nullable();
            $table->string('external_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('from_account_id')->nullable();
            $table->foreignId('to_account_id')->nullable();
            $table->string('from_currency')->nullable();
            $table->string('to_currency')->nullable();
            $table->string('fx_income_currency')->nullable();
            $table->decimal('from_amount', 28, 8)->nullable();
            $table->decimal('to_amount', 28, 8)->nullable();
            $table->decimal('fx_income_amount', 28, 8)->nullable();
            $table->decimal('rate', 28, 8)->nullable();
            $table->text('payload')->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }
};
