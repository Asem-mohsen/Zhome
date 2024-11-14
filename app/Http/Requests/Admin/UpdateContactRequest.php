<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required'],
            'title' => ['required'],
            'tagline' => ['required'],
            'meta_title' => ['required'],
            'meta_description' => ['required'],
            'google_analytics_code' => ['nullable'],
            'facebook_pixel_code' => ['nullable'],
            'enable_redirecting' => ['nullable', 'boolean'],
        ];
    }
}
