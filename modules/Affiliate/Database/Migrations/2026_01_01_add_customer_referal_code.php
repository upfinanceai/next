<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('affiliate_code')->nullable()->after('invited_by');
            $table->string('agent_id')->nullable()->after('affiliate_code')->index();      // 通过代理商链接注册，不使用 foreign key
            $table->string('partner_id')->nullable()->after('agent_id')->index();          // 所属渠道商（冗余），不使用 foreign key
            $table->string('agent_link_id')->nullable()->after('partner_id')->index();     // 具体是哪个链接，不使用 foreign key
            $table->string('registration_source')->default('direct')->after('channel')->index();
        });
    }
};
