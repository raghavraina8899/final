<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tax_name' => 'required|string|max:255',
            'tax_percentage' => 'required|string|max:255',
        ];
    }
}
