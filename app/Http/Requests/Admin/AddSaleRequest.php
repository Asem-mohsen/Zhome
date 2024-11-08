<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddSaleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'product_id' => ['required','exists:products,id'],
            'end_date'   => ['required','date','after:start_date'],
            'start_date' =>  ['required','date'],
            'sale_price' => ['required','numeric'],
        ];
    }
}