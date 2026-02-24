<?php

namespace Modules\Admin;

use Merlion\AdminProvider;
use Merlion\Components\Layouts\Admin;
use Merlion\Components\Menu;

class AdminPanelProvider extends AdminProvider
{

    public function admin(Admin $admin): Admin
    {
        return $admin
            ->id('admin')
            ->path('admin')
            ->brandName("UP Finance")
            ->default()
            ->serving(function () {
                admin()->cspNonce(app('csp-nonce'));
                admin()->menus([
                    Menu::make(
                        'dashboard',
                        __('upfinance.admin::menus.dashboard')
                    )->icon('ti ti-chart-bar icon')->content([
                        Menu::make(
                            'dashboard_operate',
                            __('upfinance.admin::menus.operate')
                        )->icon('ti ti-chart-arcs')->link('/dashboard/operate'),
                        Menu::make(
                            'dashboard_accounts',
                            __('upfinance.admin::menus.accounts')
                        )->icon('ti ti-credit-card')->link('/dashboard/accounts'),
                        Menu::make(
                            'dashboard_customers',
                            __('upfinance.admin::menus.customers')
                        )->icon('ti ti-users')->link('/dashboard/customers'),
                    ]),
                    Menu::make('settings', __('upfinance.admin::menus.settings'))->icon('ti ti-settings icon')
                        ->content([
                            Menu::make(
                                'countries',
                                __('upfinance.admin::menus.countries')
                            )->icon('ti ti-map')->link('/countries'),
                            Menu::make(
                                'currencies',
                                __('upfinance.admin::menus.currencies')
                            )->icon('ti ti-cash')->link('/currencies'),
                            Menu::make(
                                'wallet-addresses',
                                __('upfinance.admin::menus.wallets')
                            )->icon('ti ti-link')->link('/wallets'),
                            Menu::make('swap-routes', __('upfinance.admin::menus.swap-routes'))
                                ->icon('ti ti-exchange')
                                ->link('/swap-routes'),
                            Menu::make('coupons', __('upfinance.admin::menus.coupons'))
                                ->icon('ti ti-ticket')
                                ->link('/coupons'),
                            Menu::make('coupons', __('upfinance.admin::menus.agents'))
                                ->icon('ti ti-affiliate')
                                ->link('/agents'),
                            //pre-kyc cards 激活情况
                            Menu::make('pre-kyc-cards', 'Pre-KYC Cards')
                                ->icon('ti ti-credit-card')
                                ->link('/pre-kyc-cards'),
                        ]),
                ]);
                admin()->menus([
                    Menu::make(
                        'profile',
                        __('upfinance.admin::menus.profile')
                    )->icon('ti ti-user-scan icon')->link('/profile'),
                    Menu::make('logs', "Logs")->icon('ti ti-align-box-left-stretch icon')->link('/logs'),
                ], 'user');
            });
    }
}
