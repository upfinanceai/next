<?php

namespace Modules\Admin\Http\Controllers;

use Merlion\Http\Controllers\CrudController;
use Modules\Account\Models\Account;

class AccountController extends CrudController
{
    protected string $model = Account::class;

    public function beforeIndexAddAccountOwnerType()
    {
        admin()->content(view('admin::account.owner_type'));
    }

    protected function schemas(): array
    {
        return [
            'owner_type',
            'owner_id',
            'currency',
            'purpose',
            'category',
            'balance',
            'frozen_balance',
        ];
    }

    protected function searches(): array
    {
        return ['purpose'];
    }
}
