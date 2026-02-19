<?php

use Modules\Customer\Http\Controllers\Api\AuthController;

Route::group([
    'prefix'     => 'auth',
    'middleware' => 'api',
    'as'         => 'auth.',
], function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
});
