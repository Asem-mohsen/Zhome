<?php

namespace App\Http\Requests\API\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckPromocodeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'promotion' => 'required|string',
            'total_amount' => 'required|numeric',
        ];
    }
}
