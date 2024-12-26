<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }
}
