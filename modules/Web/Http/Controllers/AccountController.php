<?php

namespace Modules\Web\Http\Controllers;

class AccountController
{
    public function index()
    {
        $cash_accounts = app('account')->getCustomerCashAccounts(auth()->user());
        return view('web::accounts.index', compact('cash_accounts'));
    }

    public function showCashAccount($currency)
    {
        $account        = app('account')->getCustomerCashAccount(auth()->user(), $currency);
        $ledger_entries = app('transaction')->getEntriesBuilder($account)->paginate();
        return view('web::accounts.cash.show', compact('account', 'ledger_entries'));
    }
}
