<?php

namespace Src\ProductManagement\Product\Domain\ValueObjects;

use InvalidArgumentException;

class ProductCategory
{
    private string $value;

    public function __construct(string $value)
    {
        // Validamos que no sea vacío
        if (empty(trim($value))) {
            throw new InvalidArgumentException("La categoría del producto no puede estar vacía.");
        }

        // Opcional: validar que la categoría esté dentro de un conjunto permitido
        $allowedCategories = ['Electronics', 'Clothing', 'Books', 'Others'];
        if (!in_array($value, $allowedCategories)) {
            throw new InvalidArgumentException("La categoría '{$value}' no es válida.");
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
