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
            'Quantity' => ['required', 'numeric'],
            'Price' => ['required', 'numeric'],
            'InstallationCost' => ['nullable', 'numeric'],
            'IsBundle'    => ['required' , 'min:0' , 'max:1'],
            'Categories'  => ['required', 'exists:category,ID'],
            'SubCategory' => ['required' ,'exists:subcategory,ID'],
            'Platform' => ['required' , 'exists:platform,ID'],
            'Brand' => ['required','exists:brands,ID'],
            'Technology' => ['required'],
            'Description' => ['required' , 'max:1000'],
            'ArabicDescription' => ['required','max:1000'],
            'OtherDescription' => ['required','max:1000'],
            'OtherArabicDescription' => ['required','max:1000'],
            'Evaluation' => ['required','max:1000'],
            'ArabicEvaluation' => ['required','max:1000'],
            'Title' => ['required','max:255'],
            'OtherTitle' => ['required','max:255'],
            'ArabicTitle' => ['required','max:255'],
            'OtherArabicTitle' => ['required','max:255'],
            'Width' => ['required' , 'numeric'],
            'Height' => ['required', 'numeric'],
            'Length' => ['required', 'numeric'],
            'Color' => ['required'],
            'Capacity' => ['required'],
            'Power' => ['required'],
            'Weight' => ['required'],
            'MainImage' => ['required','max:2048'],
            'CoverImage' => ['required','max:2048'],
            'OtherImages.*'=>['required' , 'max:2048'],
            'OtherImages' => ['required','array','min:1'],
            'Video' => ['required','url'],
            'Feature' => ['required','exists:features,ID'],
            'Question' => ['required','max:1000'],
            'Answer' => ['required','max:1000'],
        ];
    }
}
