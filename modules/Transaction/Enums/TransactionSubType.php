<?php

namespace Modules\Transaction\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * DEPOSIT
 * @method static self DEPOSIT_FIAT()
 * @method static self DEPOSIT_CYPTO()
 *
 * WITHDRAW
 * @method static self WITHDRAW_FIAT()
 * @method static self WITHDRAW_CYPTO()
 *
 * FEE
 * @method static self ADMIN_FEE()
 */
class TransactionSubType extends Enum
{
}
