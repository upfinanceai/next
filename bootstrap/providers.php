<?php

use Modules\Account\AccountServiceProvider;
use Modules\Admin\AdminServiceProvider;
use Modules\Affiliate\AffiliateServiceProvider;
use Modules\Card\CardServiceProvider;
use Modules\Core\CoreServiceProvider;
use Modules\Customer\UserServiceProvider;
use Modules\Topup\TopupServiceProvider;
use Modules\Transaction\TransactionServiceProvider;

return [
    CoreServiceProvider::class,
    UserServiceProvider::class,
    AccountServiceProvider::class,
    TransactionServiceProvider::class,
    TopupServiceProvider::class,
    CardServiceProvider::class,
    AffiliateServiceProvider::class,
    AdminServiceProvider::class
];
