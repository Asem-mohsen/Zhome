<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

<<<<<<< HEAD
    public function rules(): array
    {
        return [
            'Name'                   => ['required', 'max:255' , Rule::unique('product', 'Name')->ignore($this->ID)],
            'ArabicName'             => ['nullable', 'max:255' , Rule::unique('product', 'ArabicName')->ignore($this->ID)],
            'Quantity'               => ['nullable', 'numeric'],
            'Price'                  => ['nullable', 'numeric'],
            'InstallationCost'       => ['nullable', 'numeric'],
            'IsBundle'               => ['required', 'boolean'],
            'Categories'             => ['required', 'exists:category,ID'],
            'SubCategoryID'          => ['required', 'exists:subcategory,ID'],
            'PlatformID'             => ['required', 'array','min:1' ,'exists:platform,ID'],
            'BrandID'                => ['required', 'exists:brands,ID'],
            'Technology'             => ['required' ,'array' ,'min:1'],
            'Description'            => ['required','max:1000'],
=======

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
            'PlatformID'             => ['required' , 'array','min:1'],
            'PlatformID.*'           => ['required','exists:platform,ID'],
            'BrandID'                => ['required','exists:brands,ID'],
            'Technology'             => ['required'],
            'Technology.*'           => ['required', 'array','min:1'],
            'Description'            => ['required' , 'max:1000'],
>>>>>>> c9ef07c3fb8a08fda4d41df79ae9832660976b03
            'ArabicDescription'      => ['required','max:1000'],
            'OtherDescription'       => ['nullable','max:1000'],
            'OtherArabicDescription' => ['nullable','max:1000'],
            'Evaluation'             => ['required','max:1000'],
            'ArabicEvaluation'       => ['required','max:1000'],
            'Title'                  => ['required','max:255'],
            'Title2'                 => ['required','max:255'],
            'ArabicTitle'            => ['required','max:255'],
            'ArabicTitle2'           => ['required','max:255'],
<<<<<<< HEAD
            'Width'                  => ['required','numeric'],
            'Height'                 => ['required','numeric'],
            'Length'                 => ['required','numeric'],
=======
            'Width'                  => ['required' , 'numeric'],
            'Height'                 => ['required', 'numeric'],
            'Length'                 => ['required', 'numeric'],
>>>>>>> c9ef07c3fb8a08fda4d41df79ae9832660976b03
            'Color'                  => ['required'],
            'Capacity'               => ['required'],
            'PowerConsumption'       => ['required'],
            'Weight'                 => ['required'],
<<<<<<< HEAD
            'MainImage'              => ['nullable','max:2048'],
            'CoverImage'             => ['nullable','image' ,'max:2048'],
            'OtherImages'            => ['nullable','array','min:1' ,'max:2048'],
            'Video'                  => ['required','url'],
            'FeatureID'              => ['required','array','min:1' , 'exists:features,ID'],
=======
            'MainImage'              => ['required','max:2048'],
            'CoverImage'             => ['required','max:2048'],
            'OtherImages.*'          => ['required' , 'max:2048'],
            'OtherImages'            => ['required','array','min:1'],
            'Video'                  => ['required','url'],
            'FeatureID.*'            => ['required','exists:features,ID'],
            'FeatureID'              => ['required','array','min:1'],
>>>>>>> c9ef07c3fb8a08fda4d41df79ae9832660976b03
            'Question'               => ['required','max:1000'],
            'Answer'                 => ['required','max:1000'],
        ];
    }
}