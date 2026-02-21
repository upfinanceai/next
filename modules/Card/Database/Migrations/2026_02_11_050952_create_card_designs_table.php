<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('card_designs', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable()->index();
            $table->string('image')->nullable();
            $table->string('publisher')->nullable();
            $table->string('status')->nullable()->index();
            $table->string('currency')->nullable()->index();
            $table->string('model')->nullable()->index();
            $table->string('provider')->nullable()->index();
            $table->string('external_id')->nullable()->index();
            $table->mediumText('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
