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
            'name'                     => ['required', 'max:255', 'unique:brands,name'],
            'description'              => ['required', 'max:2000'],
            'additional_description'   => ['max:2000', 'nullable'],
            'ar_description'           => ['required', 'max:2000'],
            'ar_additional_description'=> ['max:2000', 'nullable'],
            'image'                    => ['required', 'image', 'mimes:jpeg,png,jpg,gif' , 'max:2048'],
        ];
    }
}
