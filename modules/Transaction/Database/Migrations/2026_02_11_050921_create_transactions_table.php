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
            $table->string('id')->primary();
            $table->string('number')->unique();
            $table->string('type')->nullable();
            $table->string('sub_type')->nullable();
            $table->string('status')->nullable();

            $table->string('customer_id')->nullable();
            $table->string('account_id')->nullable();

            $table->decimal('amount', 18, 8)->nullable();
            $table->decimal('amount_authroized', 18, 8)->nullable();
            $table->string('currency')->nullable();

            $table->decimal('transaction_amount', 18, 8)->nullable();
            $table->decimal('transaction_amount_authroized', 18, 8)->nullable();
            $table->string('transaction_currency')->nullable();

            $table->dateTime('request_at')->nullable();
            $table->dateTime('cleared_at')->nullable();

            // exchange specific
            $table->string('from_currency')->nullable();
            $table->string('to_currency')->nullable();
            $table->string('from_account_id')->nullable();
            $table->string('to_account_id')->nullable();
            $table->decimal('from_amount', 18, 8)->nullable();
            $table->decimal('to_amount', 18, 8)->nullable();
            $table->decimal('exchange_rate', 18, 8)->nullable();

            $table->string('provider')->nullable();
            $table->string('external_id')->nullable();

            $table->text('merchant')->nullable();
            $table->text('fees')->nullable();

            $table->longText('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
