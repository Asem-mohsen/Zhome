<?php

namespace App\Http\Requests;

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
            'Market2'     => ['nulllable', 'max:255'],
            'Phone'       => ['required' , 'numeric'],
            'Phone2'      => ['nulllable', 'numeric'],
            'Location'    => ['required' , 'max:255'],
            'Location2'   => ['nulllable', 'max:255'],
            'Address'     => ['required' , 'max:255'],
            'WebsiteLink' => ['nulllable', 'url'],
            'OtherLinks'  => ['nulllable', 'url'],
            'Redirecting' => ['nulllable', 'boolean'],
        ];
    }
}