<?php

namespace Modules\Transaction\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self DRAFT()
 * @method static self PENDING()
 * @method static self POSTED()
 * @method static self SETTLING()
 * @method static self SETTLED()
 * @method static self FAILED()
 * @method static self REVERSED()
 */
class TransactionStatus extends Enum
{
}
