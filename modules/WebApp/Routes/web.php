<?php

use Modules\WebApp\Http\Controllers\AuthController;
use Modules\WebApp\Http\Middleware\WebAppAuthMiddleware;

Route::group([
    'middleware' => 'web',
    'domain'     => config('webapp.domain'),
    'as' => 'webapp.',
], function () {
    Route::view('/login', 'webapp::login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::group([
        'middleware' => WebAppAuthMiddleware::class . ':customer',
    ], function () {
        Route::view('/', 'webapp::home');
    });
});
