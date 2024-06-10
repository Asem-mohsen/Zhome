<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddCollectionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Name'             => ['required', 'max:255', 'unique:collections,Name'],
            'ArabicName'       => ['required', 'max:255', 'unique:collections,ArabicName'],
            'image'            => ['required', 'max:2048', 'image'],
            'Description'      => ['required', 'max:1000'],
            'ArabicDescription'=> ['required', 'max:1000'],
            'ProductID'        => ['required', 'array' ],
            'features[0][Feature]'            =>['required', 'max:255'],
            'features[0][Feature-Image]'      =>['required', 'max:2048','image'],
            'features[0][Feature-Description]'=>['required', 'max:1000'],
            'features[0][EndDate]'            =>['required', 'max:2048', 'image'],
        ];
    }
}
