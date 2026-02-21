<?php

namespace Modules\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:customers,email',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
