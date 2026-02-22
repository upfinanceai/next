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

            $table->string('number')->unique()->index();

            $table->string('type')->nullable();
            $table->string('sub_type')->nullable();
            $table->string('status')->nullable();

            $table->string('description')->nullable();

            $table->string('customer_id')->nullable();
            $table->string('account_id')->nullable();

            $table->decimal('amount', 28, 8)->nullable();
            $table->decimal('amount_authroized', 28, 8)->nullable();
            $table->string('currency')->nullable();

            $table->decimal('transaction_amount', 28, 8)->nullable();
            $table->decimal('transaction_amount_authroized', 28, 8)->nullable();
            $table->string('transaction_currency')->nullable();

            $table->dateTime('request_at')->nullable();
            $table->dateTime('cleared_at')->nullable();

            // exchange specific
            $table->string('from_currency')->nullable();
            $table->string('to_currency')->nullable();
            $table->string('from_account_id')->nullable();
            $table->string('to_account_id')->nullable();
            $table->decimal('from_amount', 28, 8)->nullable();
            $table->decimal('to_amount', 28, 8)->nullable();
            $table->decimal('exchange_rate', 28, 8)->nullable();

            $table->string('provider')->nullable();
            $table->string('external_id')->nullable();
            $table->string('idempotency_key')->nullable();

            $table->text('merchant')->nullable();
            $table->text('fees')->nullable();

            $table->longText('request')->nullable();
            $table->longText('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
