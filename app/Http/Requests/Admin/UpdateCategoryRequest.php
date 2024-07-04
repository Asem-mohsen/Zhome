<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UpdateCategoryRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->category->ID;
    }
    

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Category'               => ['required', 'max:255', Rule::unique('category', 'Category')->ignore($this->id)],
            'ArabicName'             => ['required', 'max:255', Rule::unique('category', 'ArabicName')->ignore($this->id)],
            'image'                  => ['nullable', 'max:2048'],
            'Description'            => ['required', 'max:1000'],
            'ArabicDescription'      => ['required', 'max:1000'],
            'OtherDescription'       => ['max:1000','nullable'],
            'OtherArabicDescription' => ['max:1000','nullable'],
        ];
    }
}
