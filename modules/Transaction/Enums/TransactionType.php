<?php

namespace Modules\Transaction\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self DEPOSIT()
 * @method static self WITHDRAW()
 * @method static self EXCHANGE()
 * @method static self INTERNAL_TRANSFER()
 * @method static self CARD_TRANSACTION()
 * @method static self CARD_TOPUP()
 * @method static self CARD_RETURN()
 * @method static self FEE()
 * @method static self ADJUSTMENT()
 */
class TransactionType extends Enum
{
}
