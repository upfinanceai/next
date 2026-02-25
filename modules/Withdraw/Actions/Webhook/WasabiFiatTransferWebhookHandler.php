<?php

namespace Modules\Withdraw\Actions\Webhook;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Card\Enum\WithdrawProvider;
use Modules\Withdraw\Services\WithdrawService;

class WasabiFiatTransferWebhookHandler
{
    use AsAction;

    public function handle($request)
    {
        WithdrawService::make()->handleWebhook($request, WithdrawProvider::WASABI());
    }

    public function asController(Request $request)
    {
        $this->handle($request);
        return response()->json([
            'success' => true,
        ]);
    }
}
