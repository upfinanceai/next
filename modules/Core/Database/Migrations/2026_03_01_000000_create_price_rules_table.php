<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('price_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('scene')->nullable();
            $table->string('status')->nullable();
            $table->json('conditions')->nullable();
            $table->json('prices')->nullable();
            $table->integer('priority')->default(0);
            $table->timestamps();
        });
    }
};
