<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    public function rules(): array
    {
        return [
            // El ID del cliente es requerido y debe existir en la tabla 'customers'.
            'customer_id' => ['required', 'integer', 'exists:customers,id'], 
            
            // La dirección de envío es requerida y debe ser un string no vacío.
            'shipping_address' => ['required', 'string', 'max:255'],
            
            // 'products' debe ser un array, requerido y no puede estar vacío.
            'products' => ['required', 'array', 'min:1'],
            
            'products.*.product_id' => ['required', 'integer', 'exists:products,id'], 
 
            'products.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'products.min' => 'Una orden debe tener al menos un producto.',
            'products.*.product_id.exists' => 'Uno de los IDs de producto proporcionados no existe.',
            'products.*.quantity.min' => 'La cantidad de cada producto debe ser al menos 1.',
        ];
    }
}
