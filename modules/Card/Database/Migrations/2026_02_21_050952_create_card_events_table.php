<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('card_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->nullable()->index();
            $table->string('type')->nullable()->index();
            $table->string('provider')->nullable()->index();
            $table->string('external_id')->nullable()->index();
            $table->mediumText('payload')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
