<?php

namespace App\Http\Requests\API\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserInfoCheckout extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'   => ['required', 'email'],
            'name'    => ['required', 'max:255', 'string'],
            'phone'   => ['required'],
            'street_address' => ['required', 'string'],
            'country_id' => ['required' , 'exists:countries,id'],
            'city_id'    => ['required'],
            'building'   => ['required'],
            'floor'      => ['required'],
            'apartment'  => ['required'],
        ];
    }
}
