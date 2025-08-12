<?php

namespace Src\ProductManagement\Product\Domain\ValueObjects;

use InvalidArgumentException;

class ProductPrice
{
    private float $value;

    public function __construct(float $value)
    {
        // Precio no puede ser negativo o cero
        if ($value <= 0) {
            throw new InvalidArgumentException("El precio debe ser mayor a cero.");
        }

        // Redondeamos a dos decimales por consistencia
        $this->value = round($value, 2);
    }

    public function value(): float
    {
        return $this->value;
    }
}
