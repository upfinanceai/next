<?php

use Modules\Withdraw\Actions\Webhook\WasabiFiatTransferWebhookHandler;

Route::post('fiat-transfer', WasabiFiatTransferWebhookHandler::class)->name('fiat-transfer');
