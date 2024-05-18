<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlatfromRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Platform' => ['required', 'max:255', Rule::unique('platform', 'Platform')->ignore($this->ID)],
            'image'=> ['nullable','max:2048'],
            'VideoURL'=>['required', 'url'],
            'MainDescription' => ['required', 'max:1000'],
            'ArabicDescription' => ['max:1000' ,'required'],
            'Question' => ['max:2000' ,'nullable'],
            'Answer' => ['max:2000' ,'nullable'],
        ];
    }
}
