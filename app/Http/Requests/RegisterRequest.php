<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return !Auth::check(); // Change to true if you want to authorize every user to make this request
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:users,email',
            'phone' => 'required|string|max:20',
        ];
    }
}
