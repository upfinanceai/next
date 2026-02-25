<?php

namespace Modules\Withdraw\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self CREATED()
 * @method static self FROZEN()
 * @method static self PENDING_REVIEW()
 * @method static self APPROVED()
 * @method static self REJECTED()
 * @method static self SUBMITTED()
 * @method static self PROCESSING()
 * @method static self SUCCESS()
 * @method static self FAILED()
 * @method static self REVERSED()
 */
class WithdrawStatus extends Enum
{
}
