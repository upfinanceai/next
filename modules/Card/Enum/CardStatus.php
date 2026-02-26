<?php

declare(strict_types=1);

namespace Modules\Card\Enum;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self PENDING()
 * @method static self ACTIVE()
 * @method static self FROZEN()
 * @method static self DELETED()
 * @method static self SUSPEND()
 */
class CardStatus extends Enum
{
}
