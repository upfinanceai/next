<?php

namespace Modules\Core\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self DEPOSIT() 入金
 * @method static self WITHDRAW() 出金
 * @method static self EXCHANGE() 兑换
 * @method static self CARD_OPEN_VIRTUAL() 兑换
 * @method static self CARD_OPEN_PHYSICAL() 兑换
 * @method static self CARD_MONTHLY_FEE() 兑换
 */
class PriceRuleScene extends Enum
{
}
