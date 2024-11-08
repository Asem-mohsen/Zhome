<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddPromocodeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'            => ['required', 'max:255' ,'unique:promotions,code'],
            'discount_amount' => ['numeric' , 'required'],
            'valid_from'      => ['date' , 'required'],
            'valid_until'     => ['date' , 'required'],
        ];
    }
}
