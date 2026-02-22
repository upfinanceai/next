<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('card_holders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->index();
            $table->foreignId('card_type_id')->nullable();
            $table->string('model')->nullable();
            $table->string('status')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('mobile_prefix')->nullable();
            $table->string('id_type')->nullable();
            $table->string('face_url')->nullable();
            $table->string('id_front_url')->nullable();
            $table->string('id_back_url')->nullable();
            $table->string('id_number')->nullable();
            $table->string('id_issue_date')->nullable();
            $table->string('id_expire_date')->nullable();
            $table->string('provider')->nullable();
            $table->string('external_id')->nullable();
            $table->string('external_card_type_id')->nullable();
            $table->text('request')->nullable();
            $table->text('payload')->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }
};
