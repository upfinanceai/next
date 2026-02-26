<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->integer('tier')->default(1);
            $table->integer('total_tiers')->default(1);
            $table->string('status')->nullable();
            $table->nullableMorphs('approvable');
            $table->string('reject_reason')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->json('person_in_charge')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
