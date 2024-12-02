<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddSubcategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('subcategories')->where(function ($query) {
                    return $query->where('category_id', $this->category_id);
                }),
            ],
            'ar_name' => ['required', 'max:255'],
            'image' => ['required', 'image'],
            'description' => ['required'],
            'ar_description' => ['nullable'],
        ];
    }
}
