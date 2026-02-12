<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('type', ['available', 'frozen'])->nullable();
            $table->string('description')->nullable();
            $table->string('owner_type')->nullable();
            $table->string('owner_id')->nullable();
            $table->string('currency')->nullable();
            $table->string('status')->nullable();
            $table->decimal('balance', 18, 8)->default(0);
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
