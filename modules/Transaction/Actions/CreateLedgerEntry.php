<?php

namespace Modules\Transaction\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Enums\AccountBalanceType;
use Modules\Transaction\Data\LedgerEntryData;
use Modules\Transaction\Enums\LedgerEntryDirection;
use Modules\Transaction\Models\LedgerEntry;

class CreateLedgerEntry
{
    use AsAction;

    public function handle(LedgerEntryData $data, $previousHash = "0")
    {
        $amount    = $data->amount;
        $is_credit = $data->direction->equals(LedgerEntryDirection::CREDIT());

        if ($data->balance_type->equals(AccountBalanceType::AVAILABLE())) {
            $balance_before = $data->account->balance ?? 0;
        } else {
            $balance_before = $data->account->frozen_balance ?? 0;
        }

        if ($data->account->is_asset) {
            $balance_after = $is_credit
                ? $balance_before - $amount
                : $balance_before + $amount;
        } else {
            $balance_after = $is_credit
                ? $balance_before + $amount
                : $balance_before - $amount;
        }

        $creaated_at = date('Y-m-d H:i:s');

        $dataToHash = $previousHash .
            $data->account->id .
            $data->account->currency .
            $amount .
            $data->direction->value .
            $creaated_at;

        $currentHash = hash('sha256', $dataToHash);

        $entry = LedgerEntry::create([
            'number' => snowflake_id(),
            'direction'  => $data->direction,
            'account_id'     => $data->account->id,
            'currency'       => $data->account->currency,
            'amount'         => $amount,
            'balance_type'   => $data->balance_type,
            'transaction_id' => $data->transaction?->id,
            'balance_before' => $balance_before,
            'balance_after'  => $balance_after,
            'owner_id'       => $data->account->owner_id,
            'hash'       => $currentHash,
            'prev_hash'  => $previousHash,
            'created_at' => $creaated_at,
        ]);

        if ($data->balance_type->equals(AccountBalanceType::AVAILABLE())) {
            $data->account->balance = $balance_after;
        } else {
            $data->account->frozen_balance = $balance_after;
        }

        $data->account->save();

        return $entry;
    }
}
