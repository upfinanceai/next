<?php

use Modules\Api\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register'])->name('register');
