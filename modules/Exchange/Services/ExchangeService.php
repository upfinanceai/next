<?php

namespace Modules\Exchange\Services;

use Modules\Core\Abstracts\Service;
use Modules\Core\Models\Currency;
use Modules\Exchange\Data\ExchangeData;

class ExchangeService extends Service
{
    public function create(ExchangeData $data)
    {
        // check balance
    }

    public function getExchangeFromCurrencies($to_currency = null)
    {
        if ($to_currency) {
            return Currency::active()->where('can_exchange_from', true)->whereNull('chain')
                ->where('code', '!=', $to_currency)->get();
        }
        return Currency::active()->where('can_exchange_from', true)->whereNull('chain')->get();
    }

    public function getExchangeToCurrencies($from_currency = null)
    {
        if ($from_currency) {
            return Currency::active()->where('can_exchange_to', true)->whereNull('chain')
                ->where('code', '!=', $from_currency)->get();
        }
        return Currency::active()->where('can_exchange_to', true)->whereNull('chain')->get();
    }

    public function getPrice(array $payload = [], $type = 'to')
    {
        if (empty($payload['from_currency']) || empty($payload['to_currency'])) {
            return $payload;
        }

        if (
            ($type == 'to' && empty($payload['from_amount']))
            ||
            ($type == 'from' && empty($payload['to_amount']))
        ) {
            return $payload;
        }

        $rate = 0.99;

        if ($type == 'to') {
            $payload['to_amount'] = number_format($payload['from_amount'] * $rate, 2);
            return $payload;
        }

        if ($type == 'from') {
            $payload['from_amount'] = number_format($payload['to_amount'] / $rate, 2);
            return $payload;
        }

        return $payload;
    }
}
