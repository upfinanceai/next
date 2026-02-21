<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()->index();
            $table->enum('direction', ['credit', 'debit'])->index();
            $table->enum('balance_type', ['available', 'frozen'])->index();
            $table->foreignId('transaction_id')->nullable()->index();
            $table->foreignId('account_id')->nullable()->index();
            $table->string('owner_id')->nullable()->index();
            $table->string('currency')->nullable()->index();
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('balance_before', 28, 8)->default(0);
            $table->decimal('balance_after', 28, 8)->default(0);
            $table->decimal('frozen_before', 28, 8)->default(0);
            $table->decimal('frozen_after', 28, 8)->default(0);
            $table->string('remark')->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }
};
