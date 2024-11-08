<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
{


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                   => ['required', 'string', 'max:255', 'unique:product_translations,name'],
            'ar_name'                => ['required', 'string', 'max:255', 'unique:product_translations,name'],
            'quantity'               => ['required', 'integer', 'min:0'],
            'price'                  => ['required', 'numeric', 'min:0'],
            'installation_cost'      => ['nullable', 'numeric', 'min:0'],
            'is_bundle'              => ['required', 'boolean'],
            'category_id'            => ['required', 'exists:categories,id'],
            'subcategory_id'         => ['required', 'exists:subcategories,id'],
            'platform_id'            => ['required', 'array', 'exists:platforms,id'],
            'brand_id'               => ['required', 'exists:brands,id'],
            'technology_id'          => ['nullable', 'array', 'exists:technologies,id'],
            'description'            => ['required','max:1000'],
            'additional_description' => ['required','max:1000'],
            'ar_description'         => ['required','max:1000'],
            'ar_additional_description' => ['nullable','max:1000'],
            'comment'                => ['required','max:1000'],
            'ar_comment'             => ['required','max:1000'],
            'title'                  => ['required'],
            'second_title'           => ['required'],
            'ar_title'               => ['required'],
            'ar_second_title'        => ['required'],
            'width'                  => ['nullable','numeric'],
            'height'                 => ['nullable','numeric'],
            'length'                 => ['nullable','numeric'],
            'color'                  => ['required', 'array', 'min:1'],
            'capacity'               => ['nullable','max:255'],
            'noise_level'            => ['nullable','max:255'],
            'weight'                 => ['nullable','max:255'],
            'power_consumption'      => ['nullable','max:255'],
            'image'                  => ['required', 'image', 'max:2048'],
            'cover_image'            => ['required', 'image', 'max:2048'],
            'other_images'           => ['nullable', 'array'],
            'other_images.*'         => ['image', 'max:2048'],
            'video_url'              => ['nullable','url'],
            'feature_id'             => ['nullable','array', 'exists:features,id'],
            'question'               => ['nullable','max:1000'],
            'answer'                 => ['nullable','max:1000'],
            'ar_question'            => ['nullable', 'string', 'max:1000'],
            'ar_answer'              => ['nullable', 'string', 'max:1000'],
        ];
    }
}
