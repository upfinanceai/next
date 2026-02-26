<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->string('device_id', 100)->nullable()->index();
            $table->string('platform', 30)->nullable();   // ios/android/web/desktop
            $table->string('app_version', 30)->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 2000)->nullable();
            $table->string('country', 2000)->nullable();
            $table->text('push_token')->nullable();
            $table->timestamp('revoked_at')->nullable()->index(); // 可选：软撤销
        });
    }
};
