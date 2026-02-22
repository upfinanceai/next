<?php

namespace Modules\Account\Data;

use Modules\Account\Enums\AccountCategory;
use Modules\Account\Enums\AccountStatus;
use Spatie\LaravelData\Data;

class AccountData extends Data
{
    public function __construct(
        public ?string $owner_type,
        public ?string $owner_id,
        public ?string $currency,
        public ?string $name,
        public ?string $number,
        public ?string $chain,
        public ?string $purpose,
        public ?AccountCategory $category,
        public ?AccountStatus $status
    ) {
    }
}
