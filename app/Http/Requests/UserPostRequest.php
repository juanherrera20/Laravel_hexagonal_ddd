<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return True;
    }

    public function rules(): array
    {
        return [
            'name'  => 'string|min:1',
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
}
