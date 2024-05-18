<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Brand' => ['required', 'max:255',  Rule::unique('brands', 'Brand')->ignore($this->ID)],
            'image' => ['nullable','max:2048'],
            'MainDescription' => ['required', 'max:1000'],
            'OtherDescription' => ['max:1000' ,'nullable'],
            'MainArabic' => ['required', 'max:1000'],
            'OtherArabicDescription' => ['max:1000' , 'nullable']
        ];
    }
}
