<?php

use Modules\Admin\Http\Controllers\AccountController;
use Modules\Admin\Http\Controllers\CurrencyController;
use Modules\Admin\Http\Controllers\Dashboard\AccountDashboard;

Route::get('dashboard/accounts', AccountDashboard::class);

Route::resource('currencies', CurrencyController::class);
Route::resource('accounts', AccountController::class);
