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
            'SubName'           => ['required' , 'max:255' , 'unique:subcategory,SubName'],
            'SubArabicName'     => ['required' , 'max:255' , 'unique:subcategory,SubArabicName'],
            'image'             => ['required' , 'max:2048'],
            'SubDescription'    => ['required' , 'max:1000'],
            'ArabicDescription' => ['required' , 'max:1000'],
        ];
    }
}
