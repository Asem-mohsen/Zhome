<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UpdateBrandRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->brand->ID;
    }
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Brand' => ['required', 'max:255',  Rule::unique('brands', 'Brand')->ignore($this->id)],
            'image' => ['nullable','max:2048'],
            'MainDescription' => ['required', 'max:1000'],
            'OtherDescription' => ['max:1000' ,'nullable'],
            'MainArabic' => ['required', 'max:1000'],
            'OtherArabicDescription' => ['max:1000' , 'nullable']
        ];
    }
}
