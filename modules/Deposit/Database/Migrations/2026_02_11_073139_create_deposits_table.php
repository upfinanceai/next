<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()->index();
            $table->string('provider')->nullable();
            $table->string('external_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('status')->nullable();
            $table->enum('type', ['crypto', 'fiat'])->nullable();
            $table->string('currency')->nullable();
            $table->string('chain')->nullable();
            $table->string('hash')->nullable();
            $table->decimal('amount', 28, 8)->nullable();
            $table->text('payload')->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }

};
