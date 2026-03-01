<?php

use Modules\Web\Http\Controllers\AccountController;
use Modules\Web\Http\Controllers\AuthController;
use Modules\Web\Http\Controllers\ExchangeController;
use Modules\Web\Http\Middleware\WebAppAuthMiddleware;

Route::group([
    'middleware' => 'web',
    'domain' => config('web.domain'),
    'as'     => 'web.',
], function () {
    Route::view('/login', 'web::login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::group([
        'middleware' => WebAppAuthMiddleware::class . ':customer',
    ], function () {
        Route::view('/', 'web::home');
        Route::get('accounts', [AccountController::class, 'index']);
        Route::get('accounts/cash/{currency}',
            [AccountController::class, 'showCashAccount'])->name('accounts.cash.show');

        Route::get('exchange', [ExchangeController::class, 'index'])->name('exchange');
    });
});
