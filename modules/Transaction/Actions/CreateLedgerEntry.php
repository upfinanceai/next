<?php

namespace Modules\Transaction\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Enums\AccountBalanceType;
use Modules\Account\Enums\AccountCategory;
use Modules\Transaction\Data\LedgerEntryData;
use Modules\Transaction\Enums\LedgerEntryDirection;
use Modules\Transaction\Models\LedgerEntry;

class CreateLedgerEntry
{
    use AsAction;

    public function handle(LedgerEntryData $data)
    {
        $amount    = $data->amount;
        $is_credit = $data->direction->equals(LedgerEntryDirection::CREDIT());
        $is_asset  = $data->account->category->equals(AccountCategory::ASSET());

        if ($data->balance_type->equals(AccountBalanceType::AVAILABLE())) {
            $balance_before = $data->account->balance ?? 0;
        } else {
            $balance_before = $data->account->frozen_balance ?? 0;
        }

        if ($is_asset) {
            $balance_after = $is_credit
                ? $balance_before - $amount
                : $balance_before + $amount;
        } else {
            $balance_after = $is_credit
                ? $balance_before + $amount
                : $balance_before - $amount;
        }

        $entry = LedgerEntry::create([
            'number' => snowflake_id(),
            'direction'      => $is_credit ? 'credit' : 'debit',
            'account_id'     => $data->account->id,
            'currency'       => $data->account->currency,
            'amount'         => $amount,
            'balance_type'   => $data->balance_type,
            'transaction_id' => $data->transaction?->id,
            'balance_before' => $balance_before,
            'balance_after'  => $balance_after,
            'owner_id'       => $data->account->owner_id,
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
