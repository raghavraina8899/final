<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
{
    public function authorize()
    {
        return true;  
    }

    public function rules()
    {
        return [
            'branch_name' => 'required|string|max:255',
            'branch_address' => 'required|string|max:255',
            'PIN' => 'required|string|max:7',
        ];
    }
}
