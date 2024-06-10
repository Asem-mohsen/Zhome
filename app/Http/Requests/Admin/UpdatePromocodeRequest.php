<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromocodeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Promocode'   =>['required','max:255','unique:promocode,Promocode,except,ID'],
            'Save'        =>['numeric' , 'required'],
            'AvailableFor'=>['integer' , 'required'],
            'Status'      =>['boolean' , 'required'],
        ];
    }
}
