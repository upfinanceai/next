<?php

namespace Modules\Deposit\Services;

use Modules\Core\Abstracts\Service;
use Modules\Core\Enums\CurrencyType;
use Modules\Core\Models\Currency;
use Modules\Customer\Models\Customer;
use Modules\Deposit\Enums\DepositMethods;

class DepositService extends Service
{
    public function getMethods($currency, ?Customer $customer = null): array
    {
        $methods = [];

        $currency_model = Currency::where(['code' => $currency])->firstOrFail();

        if ($currency_model->type->equals(CurrencyType::CRYPTO())) {
            if ($currency_model->can_deposit) {
                $methods[] = DepositMethods::CRYPTO_DEPOSIT();
            }
        }

        return $methods;
    }
}
