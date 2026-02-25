<?php

namespace Modules\Withdraw\Services;

use DB;
use Modules\Account\Actions\GetCustomerAccount;
use Modules\Card\Enum\WithdrawProvider;
use Modules\Core\Abstracts\TransactionService;
use Modules\Transaction\Actions\CreateTransaction;
use Modules\Transaction\Data\TransactionData;
use Modules\Transaction\Enums\TransactionType;
use Modules\Withdraw\Adapters\WasabiWithdrawAdapter;
use Modules\Withdraw\Contracts\WithdrawAdapter;
use Modules\Withdraw\Data\WithdrawData;
use Modules\Withdraw\Enums\WithdrawStatus;
use Modules\Withdraw\Models\Withdraw;
use phpDocumentor\Reflection\Exception;

class WithdrawService extends TransactionService
{
    protected WithdrawAdapter $provider;

    public function __construct(
        public ?Withdraw $withdraw = null,
    ) {
    }

    public function create(WithdrawData $data)
    {
        return DB::transaction(function () use ($data) {
            $account = $this->getCustomerAccount($data);

            $transaction = CreateTransaction::run(
                TransactionData::from([
                    'customer' => $data->customer,
                    'type'     => TransactionType::USER_WITHDRAW()->value,
                    'account'  => $account,
                    'amount'   => $data->amount,
                    'currency' => $data->currency,
                ])
            );

            $order = Withdraw::create([
                'number'          => snowflake_id(),
                'customer_id'     => $data->customer->id,
                'transaction_id'  => $transaction->id,
                'account_id'      => $account->id,
                'currency'        => $data->currency,
                'amount'          => $data->amount,
                'chain'           => $data->chain,
                'request_payload' => $data->toArray(),
                'requested_at'    => now(),
                'status'          => WithdrawStatus::CREATED(),
            ]);

            $adapter = $this->getAdapter($order);

            $order->update([
                'provider' => $adapter->getName(),
            ]);

            // 检查用户状态
            // 检查风控规则
            // 检查用户余额
            $order->update([
                'status'      => WithdrawStatus::APPROVED(),
                'approved_at' => now(),
            ]);

            $adapter->submit($order);
        });
    }

    protected function getCustomerAccount(WithdrawData $data)
    {
        return GetCustomerAccount::run($data->customer, $data->currency);
    }

    public function handleWebhook($payload, WithdrawProvider $provider)
    {
        $order = Withdraw::where([
            'provider'    => $provider->value,
            'external_id' => $payload['id'],
        ]);

        if (empty($order)) {
            abort(404);
        }

        $adapter = $this->getAdapter($order);
        $adapter->handleWebhook($order, $payload);
    }

    protected function getAdapter(Withdraw $withdraw): WithdrawAdapter
    {
        switch ($withdraw->currency) {
            case "USD":
            case "KRW":
                return new WasabiWithdrawAdapter();
        }
        throw new Exception("Withdraw provider not found");
    }

    public function approve($user = null, $note = null)
    {
    }

    public function reject($user = null, $note = null)
    {
    }
}
