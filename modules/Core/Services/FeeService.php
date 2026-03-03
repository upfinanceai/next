<?php

namespace Modules\Core\Services;

use Illuminate\Support\Traits\Macroable;
use Modules\Core\Abstracts\Service;
use Modules\Customer\Models\Customer;

class FeeService extends Service
{
    use Macroable;

    public function getMonthlyFee(Customer $customer)
    {
        return [
            'amount'   => 1,
            'currency' => ['USD', 'USDT'],
        ];
    }

    public function getCreateVirtualCardFee($customer, $payload)
    {
        return [
            'amount'   => 10,
            'currency' => 'USD',
        ];
    }

    public function getExtraCardFee($customer, $payload)
    {
        return 0.5;
    }
}
