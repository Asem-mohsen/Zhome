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
            'Name'                   => ['required', 'max:255' , 'unique:product,Name,except,id'],
            'ArabicName'             => ['required', 'max:255'],
            'Quantity'               => ['required', 'numeric'],
            'Price'                  => ['required', 'numeric'],
            'InstallationCost'       => ['nullable', 'numeric'],
            'IsBundle'               => ['required', 'min:0', 'max:1'],
            'Categories'             => ['required', 'exists:category,ID'],
            'SubCategoryID'          => ['required', 'exists:subcategory,ID'],
            'PlatformID'             => ['required', 'array','min:1', 'exists:platform,ID'],
            'BrandID'                => ['required', 'exists:brands,ID'],
            'Technology'             => ['required', 'min:1'],
            'Description'            => ['required','max:1000'],
            'ArabicDescription'      => ['required','max:1000'],
            'Evaluation'             => ['required','max:1000'],
            'ArabicEvaluation'       => ['required','max:1000'],
            'Title'                  => ['required'],
            'Title2'                 => ['required'],
            'ArabicTitle'            => ['required'],
            'ArabicTitle2'           => ['required'],
            'Width'                  => ['nullable','numeric'],
            'Height'                 => ['nullable','numeric'],
            'Length'                 => ['nullable','numeric'],
            'Color'                  => ['required', 'string'],
            'Color2'                 => ['nullable', 'string'],
            'Color3'                 => ['nullable', 'string'],
            'Capacity'               => ['nullable','max:255'],
            'PowerConsumption'       => ['nullable','max:255'],
            'Weight'                 => ['nullable','max:255'],
            'MainImage'              => ['required','max:2048'],
            'CoverImage'             => ['required','max:2048'],
            'OtherImages'            => ['required','array','min:1' , 'max:2048'],
            'Video'                  => ['required','url'],
            'FeatureID'              => ['nullable','array', 'exists:features,ID'],
            'Question.*'             => ['nullable','max:1000'],
            'Answer.*'               => ['nullable','max:1000'],
            'ArabicQuestion.*'       => ['nullable','max:1000'],
            'ArabicAnswer.*'         => ['nullable','max:1000'],
        ];
    }
}
