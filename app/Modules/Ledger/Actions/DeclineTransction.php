<?php

namespace App\Modules\Ledger\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class DeclineTransction
{
    use AsAction;

    public function handle($transaction, $meta = [])
    {
        if ($transaction->status != 'pending') {
            throw new \Exception('Transaction is not pending');
        }
        $transaction->status     = 'declined';
        $transaction->declined_at = now();

        if (!empty($meta)) {
            $transaction->meta = array_merge($transaction->meta ?? [], $meta);
        }

        $transaction->save();
    }
}
