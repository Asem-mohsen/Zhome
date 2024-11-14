<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateProductRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (int) $request->route()->product->ID;
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
            'quantity' => ['required'],
            'price' => ['required'],
            'installation_cost' => ['nullable'],
            'is_bundle' => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['required', 'exists:subcategories,id'],
            'platform_id' => ['required', 'exists:platforms,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'technology_id' => ['required', 'array', 'exists:technologies,id'],
            'description' => ['required'],
            'ar_description' => ['required'],
            'comment' => ['required'],
            'ar_comment' => ['required'],
            'title' => ['required'],
            'second_title' => ['required'],
            'ar_title' => ['required'],
            'ar_second_title' => ['required'],
            'image' => ['nullable'],
            'cover_image' => ['nullable'],
            'video_url' => ['nullable'],
            'feature_id' => ['nullable', 'exists:features,id'],
            'question' => ['nullable'],
            'answer' => ['nullable'],
            'ar_question' => ['nullable'],
            'ar_answer' => ['nullable'],
        ];
    }
}
