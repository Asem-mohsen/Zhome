<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (int) $request->route()->brand->id;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255',  Rule::unique('brands', 'name')->ignore($this->id)],
            'description' => ['required', 'max:1000'],
            'additional_description' => ['max:1000', 'nullable'],
            'ar_description' => ['required', 'max:2000'],
            'ar_additional_description' => ['max:1000', 'nullable'],
            'image' => ['nullable'],
        ];
    }
}
