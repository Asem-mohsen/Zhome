<?php

namespace App\Http\Requests\API\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class GetDeliveryCostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'city_id' => 'required|exists:cities,id',
        ];
    }
}
