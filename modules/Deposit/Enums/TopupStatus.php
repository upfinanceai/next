<?php

namespace Modules\Deposit\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self pending()
 * @method static self cleared()
 * @method static self cancelled()
 * @method static self suspend()
 */
class TopupStatus extends Enum
{
}
