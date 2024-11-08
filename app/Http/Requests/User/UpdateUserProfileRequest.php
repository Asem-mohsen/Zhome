<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateUserProfileRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'name'    => ['required', 'max:255'],
            'email'   => ['required', 'max:255','unique:user', 'email:rfc,dns', Rule::unique('user')->ignore($this->id)],
            'role_id' => ['required', 'exists:roles,id'],
            'Address' => ['required', 'max:255'],
            'phone'    => ['required', 'max:15' , 'unique:user_phones'],
            'phone-2'  => ['nullable', 'max:15', 'unique:user_phones'],
            'password' => ['required', 'min:9', 'max:255'],
            'floor'    => ['nullable', 'max:15'],
            'building' => ['nullable', 'max:15'],
            'apartment'=> ['nullable', 'max:15'],
            'street_address'=> ['required', 'max:255'],
            'zip_code' => ['nullable', 'max:100'],
            'country'  => ['required', 'max:255'],
            'city'     => ['required', 'max:255'],
        ];
    }
}
