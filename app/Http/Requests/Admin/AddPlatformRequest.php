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
            'Name' => ['required', 'max:255', 'unique:platform,Platform'],
            'image'=> ['required','max:2048'],
            'VideoURL'=>['required', 'url'],
            'MainDescription' => ['required', 'max:1000'],
            'ArabicDescription' => ['max:1000' ,'required'],
            'Question' => ['max:2000' ,'nullable'],
            'Answer' => ['max:2000' ,'nullable'],
        ];
    }
}