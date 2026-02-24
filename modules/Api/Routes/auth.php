<?php

use Modules\Affiliate\Api\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register'])->name('register');
