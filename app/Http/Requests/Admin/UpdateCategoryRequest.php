<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Category'               => ['required', 'max:255', Rule::unique('category', 'Category')->ignore($this->ID)],
            'ArabicName'             => ['required', 'max:255', Rule::unique('category', 'ArabicName')->ignore($this->ID)],
            'image'                  => ['nullable', 'max:2048'],
            'Description'            => ['required', 'max:1000'],
            'ArabicDescription'      => ['required', 'max:1000'],
            'OtherDescription'       => ['max:1000','nullable'],
            'OtherArabicDescription' => ['max:1000','nullable'],
        ];
    }
}
