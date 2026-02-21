<?php

namespace Modules\Transaction\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self created()
 * @method static self pending()
 * @method static self cleared()
 * @method static self declined()
 * @method static self cancelled()
 * @method static self reversed()
 */
class TransactionStatus extends Enum
{
}
