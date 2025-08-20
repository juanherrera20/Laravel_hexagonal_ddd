<?php

namespace Src\ProductManagement\Product\Domain\ValueObjects;

use InvalidArgumentException;

class ProductId
{
    private int $value;

    public function __construct(int $value)
    {
        // ID obtains by BD
        if ($value <= 0) {
            throw new InvalidArgumentException("El ID debe ser un numero mayor a 0");
        }

        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}