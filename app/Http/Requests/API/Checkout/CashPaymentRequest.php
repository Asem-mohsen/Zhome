<?php

namespace App\Http\Requests\API\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CashPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:1',
            'order_id' => 'required|exists:orders,id',
        ];
    }
}
