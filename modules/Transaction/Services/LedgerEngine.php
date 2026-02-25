<?php

namespace Modules\Transaction\Services;

use DB;
use Exception;
use Modules\Account\Actions\GetCustomerAccount;
use Modules\Account\Actions\GetSystemAccount;
use Modules\Account\Enums\AccountBalanceType;
use Modules\Account\Models\Account;
use Modules\Customer\Models\Customer;
use Modules\Transaction\Actions\CreateLedgerEntry;
use Modules\Transaction\Actions\CreateTransaction;
use Modules\Transaction\Data\LedgerEntryData;
use Modules\Transaction\Data\TransactionData;
use Modules\Transaction\Enums\LedgerEntryDirection;
use Modules\Transaction\Enums\TransactionStatus;
use Modules\Transaction\Enums\TransactionType;

class LedgerEngine
{
    public function post(TransactionType $type, array $context = [])
    {
        return DB::transaction(function () use ($type, $context) {

            $customer = Customer::find($context['customer_id'] ?? null);

            $transaction = CreateTransaction::run(TransactionData::from([
                'type'     => $type,
                'status'   => TransactionStatus::PENDING(),
                'customer' => $customer,
                'request'  => $context,
            ]));

            $entries = $this->resolveRules($type, $context);

            $totalDebit  = 0;
            $totalCredit = 0;

            foreach ($entries as $entry) {
                CreateLedgerEntry::run(
                    LedgerEntryData::from([
                        "account"      => $entry['account'],
                        "amount"       => $entry['amount'],
                        "direction"    => $entry['direction'],
                        "balance_type" => $entry['balance_type'] ?? AccountBalanceType::AVAILABLE(),
                        "transaction"  => $transaction,
                    ]),
                );

                if ($entry['direction']->equals(LedgerEntryDirection::DEBIT())) {
                    $totalDebit += $entry['amount'];
                } else {
                    $totalCredit += $entry['amount'];
                }
            }

            if (bccomp($totalDebit, $totalCredit, 8) !== 0) {
                throw new Exception('Ledger not balanced');
            }

            $transaction->update(['status' => TransactionStatus::POSTED()]);

            return $transaction;
        });
    }

    protected function resolveRules(TransactionType $type, array $context = [])
    {
        return match ($type) {
            TransactionType::USER_DEPOSIT() => [
                [
                    'account'   => $this->getTrustAccount($context),
                    'direction' => LedgerEntryDirection::DEBIT(),
                    'amount'    => $context['amount'],
                    'currency'  => $context['currency'],
                ],
                [
                    'account'   => $this->getCustomerAccount($context),
                    'direction' => LedgerEntryDirection::CREDIT(),
                    'amount'    => $context['amount'],
                    'currency'  => $context['currency'],
                ],
            ],
            default => throw new Exception('Unsupported transaction type'),
        };
    }

    protected function getTrustAccount(array $context): Account
    {
        return GetSystemAccount::run(
            currency: $context['currency'],
            purpose: 'trust',
            owner_id: $context['owner_id'],
        );
    }

    protected function getCustomerAccount(array $context): Account
    {
        $customer = Customer::findOrFail($context['customer_id']);
        return GetCustomerAccount::run(
            $customer,
            $context['currency']
        );
    }
}
