<?php

namespace App\Http\Requests\API\Cart;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'with_installation' => 'nullable|boolean',
        ];
    }
}
