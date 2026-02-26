<?php

use Modules\Api\Http\Controllers\CustomerController;

Route::get('me', [CustomerController::class, 'getProfile'])->name('profile');
Route::post('me', [CustomerController::class, 'updateProfile'])->name('update-profile');
