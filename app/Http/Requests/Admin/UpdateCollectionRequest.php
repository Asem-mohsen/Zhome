<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UpdateCollectionRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->collection->ID;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'Name'             => ['required', 'max:255', Rule::unique('collections', 'Name')->ignore($this->id)],
            'ArabicName'       => ['required', 'max:255', Rule::unique('collections', 'ArabicName')->ignore($this->id)],
            'image'            => ['nullable', 'max:2048', 'image'],
            'Description'      => ['required', 'max:1000'],
            'ArabicDescription'=> ['required', 'max:1000'],
            'ProductID'        => ['nullable', 'array' , 'exists:product,ID'],
        ];

        // Adding dynamic rules for features
        $features = $this->input('features', []);
        foreach ($features as $index => $feature) {
            $rules["features.$index.Feature"]             = ['required', 'max:255'];
            $rules["features.$index.Feature-Image"]       = ['nullable', 'max:2048', 'image'];
            $rules["features.$index.Feature-Description"] = ['required', 'max:1000'];
            $rules["features.$index.EndDate"]             = ['required', 'date'];
        }

        return $rules;
    }
}
