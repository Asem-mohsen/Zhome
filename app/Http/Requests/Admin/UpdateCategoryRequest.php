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
        $this->id = (integer) $request->route()->category->id;
    }
    

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        return [
            'name'                      => ['required', 'max:255', Rule::unique('categories', 'name')->ignore($this->id)],
            'ar_name'                   => ['required', 'max:255', Rule::unique('categories', 'ar_name')->ignore($this->id)],
            'image'                     => ['nullable', 'image'  , 'mimes:jpeg,png,jpg,gif' , 'max:2048'],
            'description'               => ['required'],
            'ar_description'            => ['required'],
            'additional_description'    => ['nullable'],
            'ar_additional_description' => ['nullable'],
        ];
    }
}
