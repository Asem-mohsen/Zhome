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
            'Name' => ['required', 'max:255'],
            'Email' => ['required', 'max:255', 'unique:admin', 'email:rfc,dns'],
            'Password' => ['required', 'min:9', 'max:255'],
            'RoleID' => ['required', 'exists:adminrole,ID'],
            'Address' => ['required', 'max:255'],
            'Country' => ['required', 'max:255'],
            'Phone' => ['required', 'max:11'],
            'DOB' => ['required', 'date', 'before_or_equal:2018-12-31', 'after_or_equal:1920-01-01'],
        ];
    }
}