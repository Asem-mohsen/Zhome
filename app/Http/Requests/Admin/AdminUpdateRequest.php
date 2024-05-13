<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class AdminUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Name' => ['required', 'max:255'],
            'Email' => ['required', 'max:255', 'unique:admin', 'email:rfc,dns',Rule::unique('admin')->ignore($this->ID),],
            'Password' => ['required', 'min:9', 'max:255'],
            'RoleID' => ['required', 'exists:adminrole,ID'],
            'Address' => ['required', 'max:255'],
            'Phone' => ['required', 'max:11'],
            'DOB' => ['required', 'date', 'before_or_equal:2018-12-31', 'after_or_equal:1920-01-01'],
        ];
    }
}