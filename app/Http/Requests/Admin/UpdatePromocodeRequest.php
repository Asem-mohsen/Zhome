<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromocodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'max:255'],
            'discount_amount' => ['required'],
            'valid_from' => ['date', 'required'],
            'status' => ['required','string'],
        ];
    }
}
