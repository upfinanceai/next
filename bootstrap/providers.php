<?php

use Modules\Affiliate\AffiliateServiceProvider;
use Modules\Customer\UserServiceProvider;

return [
    App\Providers\AppServiceProvider::class,

    UserServiceProvider::class,
    AffiliateServiceProvider::class,
];
