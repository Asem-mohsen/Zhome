<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateSubCategoryRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (int) $request->route()->subcategory->id;
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
            'ar_description' => ['nullable'],
        ];
    }
}
