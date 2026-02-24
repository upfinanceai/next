<?php

namespace Modules\Api\Http\Controllers;

use Modules\Api\Http\Requests\RegisterRequest;
use Modules\Api\Http\Resources\CustomerResource;
use Modules\Core\Abstracts\ApiController;
use Modules\Customer\Actions\CreateCustomer;
use Modules\Customer\Data\CustomerData;

class AuthController extends ApiController
{
    public function register(RegisterRequest $request)
    {
        $data = CustomerData::from($request->all());

        $customer = CreateCustomer::run($data);

        return $this->success(data: new CustomerResource($customer));
    }
}
