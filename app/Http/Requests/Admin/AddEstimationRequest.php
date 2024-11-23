<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddEstimationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'city_id'    => 'required|exists:cities,id',
            'estimation_details' => 'required|string',
            'estimated_delivery_date' => 'required|date',
        ];
    }
}
