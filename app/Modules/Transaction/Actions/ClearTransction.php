<?php

namespace App\Modules\Transaction\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class ClearTransction
{
    use AsAction;

    public function handle($transaction, $meta = [])
    {
        if ($transaction->status != 'pending') {
            throw new \Exception('Transaction is not pending');
        }
        $transaction->status     = 'cleared';
        $transaction->cleared_at = now();

        if (!empty($meta)) {
            $transaction->meta = array_merge($transaction->meta ?? [], $meta);
        }

        $transaction->save();
    }
}
