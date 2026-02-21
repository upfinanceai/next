<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('savo_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->index();
            $table->string('acc_id')->nullable()->index();
            $table->string('status')->index();
            $table->string('result')->nullable()->index();
            $table->mediumText('meta')->nullable();
            $table->timestamps();
        });
    }
};
