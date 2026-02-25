<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();

            $table->string('number', 32)->unique();
            $table->foreignId('parent_id')->nullable()->constrained('accounts');

            $table->string('name', 50)->nullable();
            $table->string('purpose', 50)->nullable();

            $table->string('status', 20);

            $table->string('owner_type', 50);
            $table->string('owner_id', 50);
            $table->string('currency', 10);

            $table->string('category', 20)->default('');
            $table->string('chain', 20)->nullable();

            $table->decimal('balance', 28, 8)->default(0);
            $table->decimal('frozen_balance', 28, 8)->default(0);
            $table->decimal('total_balance', 28, 8)->default(0);

            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                ['owner_type', 'owner_id', 'currency', 'chain'],
                'uk_accounts'
            );

            $table->index(
                ['owner_type', 'owner_id', 'status', 'currency'],
                'idx_accounts_owner_query'
            );
        });
    }
};
