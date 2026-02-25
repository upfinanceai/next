<?php

namespace Modules\Admin\Http\Controllers;

use Merlion\Http\Controllers\CrudController;
use Modules\Core\Enums\CurrencyType;
use Modules\Core\Models\Currency;

class CurrencyController extends CrudController
{
    protected string $model = Currency::class;

    protected function schemas(): array
    {
        return [
            'code',
            'symbol',
            'name',
            'type'              => [
                'type'          => 'select',
                'options'       => CurrencyType::toArray(),
                'filterable'    => true,
                'getValueUsing' => function ($schema) {
                    return $schema->getModel()->type?->value;
                },
            ],
            'rate',
            'active'            => [
                'type'   => 'toggle',
                'asIcon' => true,
            ],
            'can_deposit'       => [
                'type'   => 'toggle',
                'asIcon' => true,
            ],
            'can_withdraw'      => [
                'type'   => 'toggle',
                'asIcon' => true,
            ],
            'can_exchange_from' => [
                'type'   => 'toggle',
                'asIcon' => true,
            ],
            'can_exchange_to'   => [
                'type'   => 'toggle',
                'asIcon' => true,
            ],

        ];
    }

    protected function searches(): array
    {
        return ['code', 'name', 'symbol'];
    }
}
