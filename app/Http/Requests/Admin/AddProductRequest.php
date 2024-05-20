<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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
            'Name' => ['required', 'max:255'],
            'Quantity' => ['required', 'number', 'unique:admin', 'email:rfc,dns'],
            'Price' => ['required', 'exists:adminrole,ID'],
            'InstallationCost' => ['nullable', 'number'],
            'IsBundle'    => ['required'],
            'Categories'  => ['required'],
            'SubCategory' => ['required'],
            'Platform' => ['required'],
            'Brand' => ['required'],
            'Technology' => ['required'],
            'Description' => ['required'],
            'ArabicDescription' => ['required'],
            'OtherDescription' => ['required'],
            'OtherArabicDescription' => ['required'],
            'Evaluation' => ['required'],
            'ArabicEvaluation' => ['required'],
            'Title' => ['required'],
            'OtherTitle' => ['required'],
            'ArabicTitle' => ['required'],
            'OtherArabicTitle' => ['required'],
            'Width' => ['required'],
            'Height' => ['required'],
            'Length' => ['required'],
            'Color' => ['required'],
            'Capacity' => ['required'],
            'Power' => ['required'],
            'Weight' => ['required'],
            'MainImage' => ['required'],
            'CoverImage' => ['required'],
            'OtherImages' => ['required'],
            'Video' => ['required'],
            'Feature' => ['required'],
            'Question' => ['required'],
            'Answer' => ['required'],
        ];
    }
}