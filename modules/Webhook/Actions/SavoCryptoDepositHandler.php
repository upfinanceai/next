<?php

namespace Modules\Webhook\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Withdraw\Models\Withdraw;

class SavoCryptoDepositHandler
{
    use AsAction;

    public function handle($request)
    {
    }

    public function asController(Request $request)
    {
        $this->handle($request);
        return response()->json([
            'success' => true,
        ]);
    }
}
