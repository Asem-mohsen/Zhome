<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UpdatePlatfromRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->platform->id;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'max:255'],
            'image'          => ['required' ],
            'video_url'      => ['required', 'url'],
            'description'    => ['required', 'max:1000'],
            'ar_description' => ['max:1000' ,'required'],
        ];
    }
}
