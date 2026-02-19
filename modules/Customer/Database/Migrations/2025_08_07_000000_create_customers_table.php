<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('status')->nullable();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('password_reset_tokens')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('avatar')->nullable();
            $table->date('birthday')->nullable();
            $table->string('email')->unique()->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('mobile_prefix')->nullable();
            $table->string('mobile')->nullable();
            $table->dateTime('mobile_verified_at')->nullable();
            $table->string('country')->nullable();
            $table->string('language')->nullable();
            $table->string('timezone')->nullable();
            $table->string('currency')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('invited_by')->nullable();
            $table->string('device_token')->nullable();
            $table->dateTime('last_seen_at')->nullable();
            $table->integer('kyc_level')->default(0);
            $table->string('signup_ip')->nullable();
            $table->string('channel')->nullable();
            $table->string('savo_account_id')->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['mobile_prefix', 'mobile']);
        });
    }
};
