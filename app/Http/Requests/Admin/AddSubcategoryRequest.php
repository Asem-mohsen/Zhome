<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddSubcategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'unique:subcategories,name'],
            'ar_name' => ['required', 'max:255', 'unique:subcategories,ar_name'],
            'image' => ['required', 'image'],
            'description' => ['required'],
            'ar_description' => ['nullable'],
        ];
    }
}
