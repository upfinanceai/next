<?php

use Modules\Webhook\Actions\WasabiFiatTransferWebhookHandler;

Route::any('fiat-transfer', WasabiFiatTransferWebhookHandler::class)->name('fiat-transfer');
