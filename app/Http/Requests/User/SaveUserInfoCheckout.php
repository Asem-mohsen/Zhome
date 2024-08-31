<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserInfoCheckout extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'CartID'   => ['required'],
            'email'    => ['nullable','email'],
            'Name'     => ['nullable','max:255','string'],
            'Phone'    => ['required','numeric'],
            'Address'  => ['required','max:255'],
            'UserShippingAddress' => ['required','max:255'],
            'Country'   => ['required'],
            'City'   => ['required'],
            'Building'  => ['required'],
            'Floor'     => ['required'],
            'Apartment' => ['required'],
        ];
    }
}
