<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Api\Http\Resources\CustomerResource;
use Modules\Core\Abstracts\ApiController;

class CustomerController extends ApiController
{
    public function getProfile()
    {
        $customer = $this->getCustomer();
        return $this->success(data: CustomerResource::make($customer));
    }

    public function updateProfile(Request $request)
    {
        app('customer')->updateProfile($this->getCustomer(), $request);
        return $this->success();
    }
}
