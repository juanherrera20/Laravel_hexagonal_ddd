<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;  // True solo si la logica de autorización no se maneja aquí
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|string|min:1',
            'email' => 'required|email',
        ];
    }
}
