<?php

namespace Modules\Customer\Services;

use Arr;
use Hash;
use Modules\Core\Abstracts\Service;
use Modules\Customer\Actions\CreateCustomer;
use Modules\Customer\Data\CustomerData;
use Modules\Customer\Models\Customer;

class CustomerService extends Service
{
    public function create($request)
    {
        $data = CustomerData::from($request);
        return CreateCustomer::run($data);
    }

    public function findByEmail($email)
    {
        return Customer::where('email', $email)->first();
    }

    public function verifyPassword($customer, $password): bool
    {
        return Hash::check($password, $customer->password);
    }

    public function createToken(Customer $customer, array $payload = [])
    {
        $customer->tokens()->where('device_id', $payload['device_id'])->delete();

        $token = $customer->createToken($payload['abilities'] ?? '*');

        $token->accessToken->forceFill(Arr::only($payload, [
            'device_id',
            'platform',
            'app_version',
            'user_agent',
            'ip',
            'country',
        ]))->save();

        return $token->plainTextToken;
    }

    public function updateProfile(Customer $customer, $request)
    {
        if (!empty($request->name)) {
            $customer->name = $request->name;
        }

        $customer->save();
        return $customer;
    }
}
