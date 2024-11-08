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
            'name'     => ['required', 'max:255'],
            'email'    => ['required', 'max:255', 'unique:users', 'email:rfc,dns'],
            'password' => ['required', 'min:9', 'max:255'],
            'role_id'  => ['required', 'exists:roles,id'],
            'street_address'=> ['required', 'max:255'],
            'zip_code' => ['nullable', 'max:100'],
            'country'  => ['required', 'max:255'],
            'city'     => ['required', 'max:255'],
            'phone'    => ['required', 'max:15' , 'unique:user_phones'],
            'phone-2'  => ['nullable', 'max:15', 'unique:user_phones'],
            'floor'    => ['nullable', 'max:15'],
            'building' => ['nullable', 'max:15'],
            'apartment'=> ['nullable', 'max:15'],
        ];
    }
}