<?php

namespace Modules\Withdraw\Adapters;

use Modules\Card\Enum\WithdrawProvider;
use Modules\Withdraw\Contracts\WithdrawAdapter;
use Modules\Withdraw\Enums\WithdrawStatus;
use Modules\Withdraw\Models\Withdraw;

class WasabiWithdrawAdapter implements WithdrawAdapter
{
    public function submit(Withdraw $withdraw)
    {
        $withdraw->update([
            'status'       => WithdrawStatus::SUBMITTED(),
            'submitted_at' => now(),
            'provider'     => WithdrawProvider::WASABI(),
            'external_id'  => 'WSB-' . rand(100000, 999999),
        ]);
    }

    public function getPayloadForm($data)
    {
        return [];
    }

    public function handleWebhook(Withdraw $order, array $payload)
    {
        $order->update([
            'provider_status' => $payload['status'],
        ]);
    }

    public function getName(): string
    {
        return WithdrawProvider::WASABI()->value;
    }
}
