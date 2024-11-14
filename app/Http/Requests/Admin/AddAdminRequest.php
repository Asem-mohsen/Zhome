<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'min:9'],
            'role_id' => ['required', 'exists:roles,id'],
            'street_address' => ['required'],
            'zip_code' => ['nullable'],
            'country' => ['required'],
            'city' => ['required'],
            'phone' => ['required', 'max:15', 'unique:user_phones'],
            'phone-2' => ['nullable', 'max:15', 'unique:user_phones'],
            'floor' => ['nullable'],
            'building' => ['nullable'],
            'apartment' => ['nullable'],
        ];
    }
}
