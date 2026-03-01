<?php

namespace Modules\Web\Livewire;

use Livewire\Component;

class Exchanger extends Component
{
    public $currency_from = [];
    public $currency_to = [];

    public $from_currency = null;
    public $to_currency = null;

    public $from_amount = null;
    public $to_amount = null;

    public $last_change = null;

    public function mount(): void
    {
        $this->currency_from = app('exchange')->getExchangeFromCurrencies();
        $this->currency_to   = app('exchange')->getExchangeToCurrencies();
    }

    public function switchCurrency(): void
    {
        $tmp_to_currency     = $this->to_currency;
        $this->to_currency   = $this->from_currency;
        $this->from_currency = $tmp_to_currency;

        $tmp_to_amount     = $this->to_amount;
        $this->to_amount   = $this->from_amount;
        $this->from_amount = $tmp_to_amount;

        if ($this->last_change == 'from') {
            $this->last_change = 'to';
        } else {
            $this->last_change = 'from';
        }
        $this->onChange($this->last_change);
    }

    public function onChange($type)
    {
        $this->last_change = $type;

        if ($this->last_change == 'from') {
            $this->currency_to = app('exchange')->getExchangeToCurrencies($this->from_currency);
        } else {
            $this->currency_from = app('exchange')->getExchangeFromCurrencies($this->to_currency);
        }

        $payload = [
            'from_currency' => $this->from_currency,
            'to_currency'   => $this->to_currency,
            'from_amount'   => $this->from_amount,
            'to_amount'     => $this->to_amount,
        ];

        $price = app('exchange')->getPrice($payload, $this->last_change == 'from' ? 'to' : 'from');

        $this->to_amount   = $price['to_amount'];
        $this->from_amount = $price['from_amount'];
    }

    public function render()
    {
        return view('web::livewire.exchanger');
    }
}
