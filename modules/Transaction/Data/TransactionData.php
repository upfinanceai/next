<?php

namespace Modules\Transaction\Data;

use DateTime;
use Modules\Account\Models\Account;
use Modules\Customer\Models\Customer;
use Modules\Transaction\Enums\TransactionStatus;
use Spatie\LaravelData\Data;

/**
 * @property LedgerEntryData[] $ledger_entries
 */
class TransactionData extends Data
{

    public function __construct(
        public ?string $type,
        public ?string $sub_type,
        public ?Account $account,
        public ?Customer $customer,
        public ?float $amount,
        public ?TransactionStatus $status,
        public ?string $currency,
        public ?string $number,
        public ?string $provider,
        public ?string $external_id,
        public ?string $from_currency,
        public ?string $to_currency,
        public ?Account $from_account,
        public ?Account $to_account,
        public ?float $from_amount,
        public ?float $to_amount,
        public ?float $exchange_rate,
        public ?array $meta,
        public ?array $request,
        public ?DateTime $request_at,
        public ?array $ledger_entries,
    ) {
        if (empty($status)) {
            $this->status = TransactionStatus::DRAFT();
        }
    }
}
