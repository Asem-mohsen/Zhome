<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddFeatureRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Feature'     => ['required','max:255','unique:features,Feature,except,ID'],
            'image'       => ['required','max:2048'],
            'Description' => ['required','max:1000'],
        ];
    }
}
