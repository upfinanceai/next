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
            ->brandName("UP Finance")
            ->home(HomeController::class)
            ->default()
            ->domains(config('admin.domain'))
            ->livewire(true)
            ->middleware([AddCspHeaders::class])
            ->authenticatedRoutes(__DIR__ . '/Routes/admin.php')
            ->serving(function () {
                admin()->cspNonce(app('csp-nonce'));
                admin()->menus([
                    Menu::make(
                        'dashboard',
                        __('admin::menus.dashboard')
                    )->icon('ti ti-dashboard icon')
                        ->content([
                            Menu::make()->label('概览')->link("/"),
                            Menu::make()->label('账户')->link("/dashboard/accounts"),
                            Menu::make()->label('用户')->link("/customers"),
                            Menu::make()->label('审批')->link("/approvals"),
                        ])
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
