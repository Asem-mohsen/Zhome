<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubCategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'SubName'           => ['required' , 'max:255' , Rule::unique('subcategory', 'SubName')->ignore($this->ID)],
            'SubArabicName'     => ['required' , 'max:255' , Rule::unique('subcategory', 'SubArabicName')->ignore($this->ID)],
            'image'             => ['nullable' , 'max:2048'],
            'SubDescription'    => ['required' , 'max:1000'],
            'ArabicDescription' => ['required' , 'max:1000'],
        ];
    }
}
