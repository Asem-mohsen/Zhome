<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateCategoryRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (int) $request->route()->category->id;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name' => ['required', 'max:255'],
            'ar_name' => ['required', 'max:255'],
            'image' => ['nullable'],
            'description' => ['required'],
            'ar_description' => ['required'],
            'additional_description' => ['nullable'],
            'ar_additional_description' => ['nullable'],
        ];
    }
}
