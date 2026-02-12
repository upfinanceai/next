<?php

namespace App\Modules\Exchange\Actions;

use App\Models\Transaction;
use DB;

class ExchangeCurrency
{

    public static function handle($user, $from_currency, $to_currency, $from_amount, $to_amount)
    {
        DB::beginTransaction();
        $transaction = Transaction::create([
            'type'    => 'exchange',
            'status'  => 'cleared',
            'user_id' => $user->id,
        ]);



        DB::commit();
    }
}
