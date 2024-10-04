<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_name' => 'required|string|max:255',
            'product_cost'=> 'required|string|max:255',
            'tax_id'=> 'required',
            'product_description'=> 'required|string|max:255',
        ];
    }
}
