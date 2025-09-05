<?php

declare(strict_types=1);

namespace Src\OrderManagement\Order\Infrastructure\Adapters;

use Src\OrderManagement\Order\Domain\Contracts\ProductLookupServiceInterface;
use Src\OrderManagement\Order\Domain\ValueObjects\ProductDataForOrder;

// Necesitamos importar la INTERFAZ del caso de uso de Product Management
// Este es el acoplamiento controlado a la API (Puerto de Entrada) del otro BC
use Src\ProductManagement\Product\Application\GetProductByIdUseCase;

class ProductLookupAdapter implements ProductLookupServiceInterface
{
    private GetProductByIdUseCase $getProductByIdUseCase; // Inyecta el caso de uso del BC de Producto

    public function __construct(GetProductByIdUseCase $getProductByIdUseCase)
    {
        $this->getProductByIdUseCase = $getProductByIdUseCase;
    }

    public function getProductDataForOrder(int $productId): ?ProductDataForOrder
    {
        
        $product = $this->getProductByIdUseCase->execute($productId);

        if (!$product) {
            return null; // Producto no encontrado en el otro contexto
        }

        /*
            Estructura que devuelve el caso de uso de Product
            {
                "id": 1,
                "name": "Taladro manual",
                "category": "Others",
                "price": 309.49
            }
        */
       
        return new ProductDataForOrder(
            (int) $product->id,    // Aseguramos que sea string si el ID 
            (string) $product->name,
            (float) $product->price   
        );
    }
}