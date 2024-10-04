<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'city_name' => 'required|string|max:255',
            'PIN' => 'required|string|max:7|unique:cities',
            'state_id'=> 'required',
        ];
    }
}
