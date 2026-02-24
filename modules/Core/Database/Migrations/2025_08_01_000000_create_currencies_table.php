<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->boolean('active')->default(true);
            $table->string('name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('image')->nullable();
            $table->string('symbol')->nullable();
            $table->string('chain')->nullable();
            $table->integer('precision')->default(2);
            $table->boolean('is_crypto')->default(false);
            $table->boolean('is_base')->default(false);
            $table->boolean('can_deposit')->default(false);
            $table->boolean('can_withdraw')->default(false);
            $table->boolean('can_exchange_from')->default(false);
            $table->boolean('can_exchange_to')->default(false);
            $table->decimal('rate', 30, 8)->nullable();
            $table->integer('order')->default(0);
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }
};
