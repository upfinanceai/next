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
        Schema::create('card_designs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['virtual', 'physical'])->nullable();
            $table->string('provider')->nullable();
            $table->string('image')->nullable();
            $table->string('publisher')->nullable();
            $table->string('status')->nullable();
            $table->string('currency')->nullable();
            $table->string('external_id')->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_designs');
    }
};
