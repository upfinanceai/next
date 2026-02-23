<?php

return [
    Modules\Account\AccountServiceProvider::class,
    Modules\Affiliate\AffiliateServiceProvider::class,
    Modules\Card\CardServiceProvider::class,
    Modules\Core\CoreServiceProvider::class,
    Modules\Customer\CustomerServiceProvider::class,
    Modules\Topup\TopupServiceProvider::class,
    Modules\Transaction\TransactionServiceProvider::class,

    App\Providers\Filament\AdminPanelProvider::class,
];
