<?php

namespace Modules\Customer\Http\Controllers\Api;

use Modules\Customer\Actions\CreateCustomer;
use Modules\Customer\Data\CustomerData;
use Modules\Customer\Http\Requests\RegisterRequest;
use Modules\Customer\Http\Resources\CustomerResource;
use Modules\Support\Base\ApiController;

class AuthController extends ApiController
{
    public function register(RegisterRequest $request)
    {
        $data = CustomerData::from($request->all());

        $customer = CreateCustomer::run($data);

        return $this->success(data: new CustomerResource($customer));
    }
}
