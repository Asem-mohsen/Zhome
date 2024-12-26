<?php

namespace App\Http\Requests\API\Cart;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartInstallationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:order_product,product_id',
            'with_installation' => 'required|boolean',
        ];
    }
}
