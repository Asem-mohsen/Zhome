<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'Owner'       => ['required'],
            'NumberofEmp' => ['nullable' , 'numeric'],
            'Market'      => ['required' , 'max:255'],
            'Market2'     => ['nullable', 'max:255'],
            'Phone'       => ['required' , 'numeric'],
            'Phone2'      => ['nullable', 'numeric'],
            'Location'    => ['required' , 'max:255'],
            'Location2'   => ['nullable', 'max:255'],
            'Address'     => ['required' , 'max:255'],
            'WebsiteLink' => ['nullable', 'url'],
            'OtherLinks'  => ['nullable', 'url'],
            'Redirecting' => ['nullable', 'boolean'],
        ];
    }
}