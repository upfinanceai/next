<?php

use Modules\Account\AccountServiceProvider;
use Modules\Affiliate\AffiliateServiceProvider;
use Modules\Card\CardServiceProvider;
use Modules\Customer\UserServiceProvider;
use Modules\Support\SupportServiceProvider;
use Modules\Topup\TopupServiceProvider;
use Modules\Transaction\TransactionServiceProvider;

return [
    SupportServiceProvider::class,
    UserServiceProvider::class,
    AccountServiceProvider::class,
    TransactionServiceProvider::class,
    TopupServiceProvider::class,
    CardServiceProvider::class,
    AffiliateServiceProvider::class,
];
