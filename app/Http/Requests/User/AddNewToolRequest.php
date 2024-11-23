<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AddNewToolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'max:255', 'string'],
            'email'   => ['required', 'max:255', 'email'],
            'phone'   => ['required'],
            'address' => ['required', 'max:255'],
            'country_id' => ['required'],
            'city_id'    => ['required'],
            'file'    => ['nullable'],
            'installed' => ['required'],
            'building_type' => ['required'],
            'rooms' => ['required'],
            'room_input' => ['nullable'],
            'categories' => ['required'],
            'system_type' => ['required'],
            'platform_id' => ['required'],
            'package' => ['required'],
        ];
    }
}
