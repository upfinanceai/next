<?php

use Modules\Webhook\Actions\SavoCryptoDepositHandler;

// Crypto deposit wehbook
Route::any('crypto-deposit', SavoCryptoDepositHandler::class)->name('crypto-deposit');
