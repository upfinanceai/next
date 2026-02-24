<?php

use Modules\Admin\AdminServiceProvider;

return [
    Modules\Account\AccountServiceProvider::class,
    Modules\Affiliate\AffiliateServiceProvider::class,
    Modules\Card\CardServiceProvider::class,
    Modules\Core\CoreServiceProvider::class,
    Modules\Customer\CustomerServiceProvider::class,
    Modules\Topup\TopupServiceProvider::class,
    Modules\Transaction\TransactionServiceProvider::class,

    AdminServiceProvider::class
];
