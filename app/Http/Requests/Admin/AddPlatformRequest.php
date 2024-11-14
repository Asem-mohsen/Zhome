<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddPlatformRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'unique:platforms,name'],
            'image' => ['required', 'image'],
            'video_url' => ['required', 'url'],
            'description' => ['required', 'max:1000'],
            'ar_description' => ['max:1000', 'required'],
            'question' => ['array', 'nullable'],
            'question.*' => ['max:2000', 'nullable'],
            'answer' => ['array', 'nullable'],
            'answer.*' => ['max:2000', 'nullable'],
        ];
    }
}
