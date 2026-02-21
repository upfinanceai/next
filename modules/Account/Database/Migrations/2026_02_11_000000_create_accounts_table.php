<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('number')->index();
            $table->string('name')->nullable();
            $table->string('owner_type')->nullable();
            $table->string('owner_id')->nullable();
            $table->string('currency')->nullable();
            $table->string('chain')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->index();
            $table->decimal('balance', 28, 8)->default(0);
            $table->decimal('frozen_balance', 28, 8)->default(0);
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }

};
