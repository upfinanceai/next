<?php

namespace Modules\Core\Abstracts;

use Illuminate\Http\JsonResponse;
use Modules\Customer\Models\Customer;

abstract class ApiController
{
    protected Customer $customer;

    protected function fail(string $message = null, $data = [], int $code = 400)
    {
        return $this->apiResponse(data: $data, message: $message, code: $code);
    }

    protected function success(string $message = null, $data = [], int $code = 200)
    {
        return $this->apiResponse(data: $data, message: $message, code: $code);
    }

    protected function apiResponse($data = null, ?string $message = null, int $code = 200): JsonResponse
    {
        $response = array_filter(compact('message', 'data'));
        return response()->json($response, $code);
    }

    protected function getCustomer(): Customer
    {
        if (empty($this->customer)) {
            $this->customer = Customer::findOrFail(auth()->id());
        }
        return $this->customer;
    }
}

