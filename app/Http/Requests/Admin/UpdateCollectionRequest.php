<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateCollectionRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (int) $request->route()->collection->ID;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'ar_name' => ['required'],
            'image' => ['nullable'],
            'description' => ['required'],
            'ar_description' => ['required'],
            'product_id' => ['required'],
        ];
    }
}
