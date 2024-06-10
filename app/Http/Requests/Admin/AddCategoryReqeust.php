<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryReqeust extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Category'               => ['required', 'max:255', 'unique:category,Category'],
            'ArabicName'             => ['required', 'max:255', 'unique:category,ArabicName'],
            'image'                  => ['required','max:2048'],
            'Description'            => ['required', 'max:1000'],
            'ArabicDescription'      => ['required', 'max:1000'],
            'OtherDescription'       => ['max:1000','nullable'],
            'OtherArabicDescription' => ['max:1000','nullable'],
        ];
    }
}
