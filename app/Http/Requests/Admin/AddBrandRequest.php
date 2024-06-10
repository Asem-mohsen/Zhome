<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddBrandRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Brand' => ['required', 'max:255', 'unique:brands,Brand'],
            'image' => ['required'],
            'MainDescription' => ['required', 'max:1000'],
            'OtherDescription' => ['max:1000' ,'nullable'],
            'MainArabic' => ['required', 'max:1000'],
            'OtherArabicDescription' => ['max:1000' , 'nullable']
        ];
    }
}
