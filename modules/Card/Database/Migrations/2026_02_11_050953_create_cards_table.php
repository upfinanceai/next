<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('card_design_id')->nullable()->index();
            $table->string('customer_id')->nullable()->index();
            $table->string('holder_name')->nullable();
            $table->string('otp_email')->nullable();
            $table->string('otp_mobile_prefix')->nullable();
            $table->string('otp_mobile')->nullable();
            $table->integer('last_no')->nullable();
            $table->string('status')->nullable();
            $table->string('currency')->nullable();
            $table->string('remark')->nullable();
            $table->string('external_id')->nullable();
            $table->mediumText('meta')->nullable();
            $table->timestamps();
        });
    }
};
