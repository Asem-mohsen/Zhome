<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'Name' => ['required' , 'max:240' , 'min:3'],
            'email'=> ['required' , 'email' , Rule::unique('users')->ignore($userId)],
            'Phone'=> ['required' , 'numeric'],
            'Address'=>['required', 'max:255'],
            'Password'=>['nullable', 'max:255']

        ];
    }
}
