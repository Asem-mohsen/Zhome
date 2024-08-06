<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UpdateFeatureRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->feature->ID;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Feature'        => ['required','max:255', Rule::unique('features', 'Feature')->ignore($this->id)],
            'image'          => ['nullable','max:4048'],
            'Description'    => ['required','max:1000'],
            'Description_ar' => ['required','max:1000'],
        ];
    }
}
