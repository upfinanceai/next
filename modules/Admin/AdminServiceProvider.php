<?php

declare(strict_types=1);

namespace Modules\Admin;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Admin\Livewire\Counter;

class AdminServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->register(AdminPanelProvider::class);
    }

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/Resources/Lang', 'upfinance.admin');

        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'admin');
        Livewire::component('counter', Counter::class);
    }
}
