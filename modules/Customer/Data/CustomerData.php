<?php

namespace Modules\Customer\Data;

use Spatie\LaravelData\Data;

class CustomerData extends Data
{
    public function __construct(
        public ?string $name,
        public ?string $email,
        public ?string $password,
        public ?string $mobile_prefix,
        public ?string $mobile,
        public ?string $affiliate_code,
        public ?string $signup_ip,
        public ?array $meta,
    ) {

    }
}
