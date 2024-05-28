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
            'ProductID'  => ['required','exists:product,ID'],
            'EndDate'    => ['required','date','after:StartDate'],
            'Amount'     => ['required','numeric'],
            'PriceBefore'=> ['numeric'],
            'PriceAfter' => ['numeric'],
        ];
    }
}