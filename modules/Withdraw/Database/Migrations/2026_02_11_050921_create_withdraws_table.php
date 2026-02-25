<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();

            $table->string('number')->unique();
            $table->string('status')->index();

            $table->foreignId('customer_id')->nullable();
            $table->foreignId('account_id')->nullable();
            $table->foreignId('transaction_id')->nullable();

            $table->string('currency')->nullable();
            $table->decimal('amount', 28, 8)->nullable();
            $table->string('chain')->nullable();

            $table->dateTime('requested_at')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('completed_at')->nullable();

            $table->string('provider')->nullable();
            $table->string('provider_status')->nullable();
            $table->string('external_id')->nullable();
            $table->string('idempotency_key')->nullable();

            $table->text('request_payload')->nullable();
            $table->text('submit_payload')->nullable();
            $table->text('result_payload')->nullable();
            $table->text('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
