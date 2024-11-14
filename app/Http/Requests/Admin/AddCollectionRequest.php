<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'ar_name' => ['required'],
            'image' => ['required'],
            'description' => ['required'],
            'ar_description' => ['required'],
            'product_id' => ['required', 'array'],
        ];
    }
}
