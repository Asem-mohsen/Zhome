<?php

namespace App\Http\Requests\API\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class CreatSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }
}
