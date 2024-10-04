<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCountryRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // Set to true to allow all users, or add logic for specific users
    }

    public function rules()
    {
        return [
            'country_name' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:countries',
        ];
    }
}
