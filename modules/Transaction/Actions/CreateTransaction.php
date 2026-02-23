<?php

namespace Modules\Transaction\Actions;

use Exception;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Transaction\Data\TransactionData;
use Modules\Transaction\Events\TransactionCreatedEvent;
use Modules\Transaction\Models\Transaction;

class CreateTransaction
{
    use AsAction;

    public function handle(TransactionData $data)
    {
        if (!empty($data->external_id)) {
            $transaction = Transaction::where('external_id', $data->external_id)->first();
            if ($transaction) {
                throw new Exception('Transaction already exists');
            }
        }

        if (empty($data->number)) {
            $data->number = $this->generateNumber($data);
        }

        $transaction = Transaction::create([
            'external_id'   => $data->external_id,
            'number'        => $data->number,
            'status'        => $data->status,
            'customer_id'   => $data->customer?->id,
            'type'          => $data->type,
            'sub_type'      => $data->sub_type,
            'amount'        => $data->amount,
            'currency'      => $data->currency,
            'from_currency' => $data->from_currency,
            'to_currency'   => $data->to_currency,
            'from_amount'   => $data->from_amount,
            'to_amount'     => $data->to_amount,
            'exchange_rate' => $data->exchange_rate,
            'meta'          => $data->meta,
        ]);

        TransactionCreatedEvent::dispatch($transaction);

        return $transaction;
    }

    public function generateNumber(TransactionData $data)
    {
        return date('Ymd') . app('Kra8\Snowflake\Snowflake')->next();
    }
}
