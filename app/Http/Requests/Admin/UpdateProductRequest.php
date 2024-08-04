<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UpdateProductRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->product->ID;
    }


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Name'                   => ['required', 'max:255' , Rule::unique('product', 'Name')->ignore($this->id)],
            'ArabicName'             => ['nullable', 'max:255' , Rule::unique('product', 'ArabicName')->ignore($this->id)],
            'Quantity'               => ['nullable', 'numeric'],
            'Price'                  => ['nullable', 'numeric'],
            'InstallationCost'       => ['nullable', 'numeric'],
            'IsBundle'               => ['nullable', 'boolean'],
            'Categories'             => ['nullable', 'exists:category,ID'],
            'SubCategoryID'          => ['nullable', 'exists:subcategory,ID'],
            'PlatformID'             => ['nullable', 'array','min:1' ,'exists:platform,ID'],
            'BrandID'                => ['nullable', 'exists:brands,ID'],
            'Technology'             => ['required' ,'array' ,'min:1'],
            'Description'            => ['required','max:1000'],
            'ArabicDescription'      => ['required','max:1000'],
            'OtherDescription'       => ['nullable','max:1000'],
            'OtherArabicDescription' => ['nullable','max:1000'],
            'Evaluation'             => ['required','max:1000'],
            'ArabicEvaluation'       => ['required','max:1000'],
            'Title'                  => ['required','max:255'],
            'Title2'                 => ['required','max:255'],
            'ArabicTitle'            => ['required','max:255'],
            'ArabicTitle2'           => ['required','max:255'],
            'Width'                  => ['nullable','numeric'],
            'Height'                 => ['nullable','numeric'],
            'Length'                 => ['nullable','numeric'],
            'Color'                  => ['nullable'],
            'Capacity'               => ['nullable'],
            'PowerConsumption'       => ['nullable'],
            'Weight'                 => ['nullable'],
            'MainImage'              => ['nullable','max:2048'],
            'CoverImage'             => ['nullable','image'],
            'OtherImages'            => ['nullable','array','min:1' ,'max:2048'],
            'Video'                  => ['nullable','url'],
            'FeatureID'              => ['nullable','array','min:1' , 'exists:features,ID'],
            'Question'               => ['nullable','max:1000'],
            'Answer'                 => ['nullable','max:1000'],
        ];
    }
}
