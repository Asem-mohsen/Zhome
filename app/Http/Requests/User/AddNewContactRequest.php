<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AddNewContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'Phone' => ['nullable', 'numeric'],
            'Subject' => ['required', 'max:255'],
            'UsersQuestion' => ['required', 'max:1000'],
        ];
    }
}
