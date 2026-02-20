<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('type')->nullable();
            $table->string('sub_type')->nullable();
            $table->string('status')->nullable();
            $table->enum('direction', ['credit', 'debit']);
            $table->enum('balance_type', ['available', 'frozen']);
            $table->string('transaction_id')->nullable();
            $table->string('account_id')->nullable();
            $table->string('owner_id')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('amount', 18, 8)->nullable();
            $table->decimal('balance_before', 18, 8)->nullable();
            $table->decimal('balance_after', 18, 8)->nullable();
            $table->decimal('frozen_before', 18, 8)->nullable();
            $table->decimal('frozen_after', 18, 8)->nullable();
            $table->string('remark')->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_entries');
    }
};
