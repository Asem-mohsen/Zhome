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
            'email' => ['nullable', 'email'],
            'name' => ['nullable', 'max:255', 'string'],
            'phone' => ['required', 'array'],
            'phone.*' => ['required', 'numeric'],
            'street_address' => ['required', 'string'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'building' => ['required'],
            'floor' => ['required'],
            'apartment' => ['required'],
        ];
    }
}
