<?php

namespace Modules\Affiliate\Api\Http\Controllers;

use Modules\Affiliate\Api\Http\Requests\RegisterRequest;
use Modules\Affiliate\Api\Http\Resources\CustomerResource;
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
