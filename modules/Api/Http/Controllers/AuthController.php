<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Api\Http\Requests\LoginRequest;
use Modules\Api\Http\Requests\RegisterRequest;
use Modules\Api\Http\Resources\CustomerResource;
use Modules\Core\Abstracts\ApiController;
use Str;

class AuthController extends ApiController
{
    public function register(RegisterRequest $request)
    {

        $customer = app('customer')->create($request->all());

        return $this->success(data: CustomerResource::make($customer));
    }

    public function login(LoginRequest $request)
    {
        $customer = app('customer')->findByEmail($request->email);
        if (empty($customer)) {
            abort(401);
        }

        if (!app('customer')->verifyPassword($customer, $request->password)) {
            abort(401);
        }

        return $this->success(data: [
            'token'    => app('customer')->createToken($customer, [
                'device_id'   => $request->device_id ?? Str::random(),
                'platform'    => $request->platform ?? 'webapp',
                'app_version' => $request->app_version ?? '0',
                'user_agent'  => Str::substr($request->header('user-agent') ?? '', 0, 500),
                'ip'          => $request->ip(),
                'country'     => $request->country ?? '',
            ]),
            'customer' => CustomerResource::make($customer),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success();
    }

}
