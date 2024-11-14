<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255'],
            'role_id' => ['required', 'exists:roles,id'],
            'phone' => ['required', 'max:15'],
            'floor' => ['nullable', 'max:15'],
            'building' => ['nullable', 'max:15'],
            'apartment' => ['nullable', 'max:15'],
            'street_address' => ['required', 'max:255'],
            'zip_code' => ['nullable', 'max:100'],
            'country' => ['required', 'max:255'],
            'city' => ['required', 'max:255'],
        ];
    }
}
