<?php

namespace Modules\Customer;

use Illuminate\Support\ServiceProvider;
use Merlion\Components\Menu;

class AdminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        admin()->serving(function ($admin) {
            $admin->menus([
                Menu::make(
                    'customers',
                    __('upfinance.admin::menus.customers')
                )->icon('ti ti-users icon')->content([
                    Menu::make(
                        'customers_list',
                        __('upfinance.admin::menus.customers')
                    )->icon('ti ti-users')->link('/customers'),
                    Menu::make(
                        'customer_batch_import',
                        'Batch Import'
                    )->icon('ti ti-file-upload')->link('/customer-batch-import'),
                ]),
            ]);
        });
    }
}
