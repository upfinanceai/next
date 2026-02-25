<?php

namespace Modules\Core\Abstracts;

use Modules\Customer\Models\Customer;
use Modules\Transaction\Models\Transaction;

abstract class TransactionService
{
    public static function make(...$args)
    {
        return new static(...$args);
    }
}
