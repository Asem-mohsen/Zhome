<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryReqeust extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                      => ['required', 'max:255', 'unique:categories,name'],
            'ar_name'                   => ['required', 'max:255', 'unique:categories,ar_name'],
            'image'                     => ['required', 'image'  , 'mimes:jpeg,png,jpg,gif' , 'max:2048'],
            'description'               => ['required'],
            'ar_description'            => ['required'],
            'additional_description'    => ['nullable'],
            'ar_additional_description' => ['nullable'],
        ];
    }
}
