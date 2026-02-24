<?php

use Modules\Admin\AdminServiceProvider;
use Modules\Api\ApiServiceProvider;

return [
    Modules\Account\AccountServiceProvider::class,
    Modules\Affiliate\AffiliateServiceProvider::class,
    Modules\Card\CardServiceProvider::class,
    Modules\Core\CoreServiceProvider::class,
    Modules\Customer\CustomerServiceProvider::class,
    Modules\Topup\TopupServiceProvider::class,
    Modules\Transaction\TransactionServiceProvider::class,

    ApiServiceProvider::class,
    AdminServiceProvider::class
];
