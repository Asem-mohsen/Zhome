<?php

namespace App\Http\Requests\API\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'amount'   => ['required', 'numeric'],
        ];
    }
}
