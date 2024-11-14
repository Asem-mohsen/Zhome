<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AddNewToolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'UserID' => ['nullable', 'exists:user,id'],
            'UnkownID' => ['nullable'],
            'Name' => ['required', 'max:255', 'string'],
            'Email' => ['required', 'max:255', 'email'],
            'Phone' => ['required', 'numeric'],
            'Address' => ['required', 'max:255'],
            'Country' => ['required'],
            'City' => ['required'],
            'file' => ['nullable', 'file'],
            'Installed' => ['required', 'min:1'],
            'BuildingProject' => ['required', 'min:1'],
            'Rooms' => ['required'],
            'RoomsInput' => ['nullable', 'numeric'],
            'Categories' => ['required', 'min:1'],
            'SystemType' => ['required', 'min:1'],
            'Platform' => ['required', 'min:1'],
            'Package' => ['required', 'min:1'],
        ];
    }
}
