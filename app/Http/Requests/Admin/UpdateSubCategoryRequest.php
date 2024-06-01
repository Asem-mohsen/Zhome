<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UpdateSubCategoryRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->subcategory->ID;
    }
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        return [
            'SubName'           => ['required' , 'max:255' ],
            'SubArabicName'     => ['required' , 'max:255' , Rule::unique('subcategory', 'SubArabicName')->ignore($this->id)],
            'image'             => ['nullable' , 'max:2048'],
            'SubDescription'    => ['required' , 'max:1000'],
            'ArabicDescription' => ['required' , 'max:1000'],
        ];
    }
}
