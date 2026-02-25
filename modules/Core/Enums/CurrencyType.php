<?php

namespace Modules\Core\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self FIAT() 法币
 * @method static self CRYPTO() 虚拟货币
 * @method static self VIRTUAL() 平台虚拟币
 */
class CurrencyType extends Enum
{
}
