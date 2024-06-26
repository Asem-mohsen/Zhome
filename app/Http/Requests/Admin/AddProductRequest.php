<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Name'                   => ['required', 'max:255'],
            'ArabicName'             => ['nullable', 'max:255'],
            'Quantity'               => ['required', 'numeric'],
            'Price'                  => ['required', 'numeric'],
            'InstallationCost'       => ['nullable', 'numeric'],
            'IsBundle'               => ['required' , 'min:0' , 'max:1'],
            'Categories'             => ['required', 'exists:category,ID'],
            'SubCategoryID'          => ['required' ,'exists:subcategory,ID'],
            'PlatformID'             => ['required' , 'array','min:1', 'exists:platform,ID'],
            'BrandID'                => ['required','exists:brands,ID'],
            'Technology'             => ['required' , 'min:1'],
            'Description'            => ['required' , 'max:1000'],
            'ArabicDescription'      => ['required','max:1000'],
            'OtherDescription'       => ['nullable','max:1000'],
            'OtherArabicDescription' => ['nullable','max:1000'],
            'Evaluation'             => ['required','max:1000'],
            'ArabicEvaluation'       => ['required','max:1000'],
            'Title'                  => ['required','max:255'],
            'Title2'                 => ['required','max:255'],
            'ArabicTitle'            => ['required','max:255'],
            'ArabicTitle2'           => ['required','max:255'],
            'Width'                  => ['required','numeric'],
            'Height'                 => ['required','numeric'],
            'Length'                 => ['required','numeric'],
            'Color'                  => ['required'],
            'Capacity'               => ['required'],
            'PowerConsumption'       => ['required'],
            'Weight'                 => ['required'],
            'MainImage'              => ['required','max:2048'],
            'CoverImage'             => ['required','max:2048'],
            'OtherImages'            => ['required','array','min:1' , 'max:2048'],
            'Video'                  => ['required','url'],
            'FeatureID'              => ['required','array','min:1' , 'exists:features,ID'],
            'Question'               => ['required','max:1000'],
            'Answer'                 => ['required','max:1000'],
        ];
    }
}