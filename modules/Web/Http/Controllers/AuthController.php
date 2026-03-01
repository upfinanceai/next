<?php

namespace Modules\Web\Http\Controllers;

use Modules\Web\Http\Requests\LoginRequest;

class AuthController
{
    public function login(LoginRequest $request)
    {
        $customer = app('customer')->findByEmail($request->email);

        if (!$customer) {
            return back()->withErrors(['email' => 'Invalid credentials'])
                ->withInput($request->only('email'));
        }

        if (app('customer')->verifyPassword($customer, $request->password)) {
            auth('customer')->login($customer);
            return redirect()->intended();
        }
        return back()->withErrors(['email' => 'Invalid credentials'])
            ->withInput($request->only('email'));
    }
}
