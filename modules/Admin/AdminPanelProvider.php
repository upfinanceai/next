<?php

namespace Modules\Admin;

use Merlion\AdminProvider;
use Merlion\Components\Layouts\Admin;
use Merlion\Components\Menu;
use Modules\Admin\Http\Controllers\HomeController;
use Spatie\Csp\AddCspHeaders;

class AdminPanelProvider extends AdminProvider
{

    public function admin(Admin $admin): Admin
    {
        return $admin
            ->id('admin')
            ->domains([
                config('admin.domain'),
            ])
            ->livewire(true)
            ->home(HomeController::class)
            ->brandName("UP Finance")
            ->middleware([AddCspHeaders::class])
            ->default()
            ->serving(function () {
                admin()->cspNonce(app('csp-nonce'));
                admin()->menus([
                    Menu::make(
                        'dashboard',
                        __('admin::menus.dashboard')
                    )->icon('ti ti-chart-bar icon')->link('/')
                ]);
                admin()->menus([
                    Menu::make(
                        'profile',
                        __('admin::menus.profile')
                    )->icon('ti ti-user-scan icon')->link('/profile'),
                    Menu::make('logs', "Logs")->icon('ti ti-align-box-left-stretch icon')->link('/logs'),
                ], 'user');
            });
    }
}
