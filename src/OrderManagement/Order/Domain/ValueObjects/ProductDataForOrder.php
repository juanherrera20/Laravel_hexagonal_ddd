<?php

declare(strict_types=1);

namespace Src\OrderManagement\Order\Domain\ValueObjects;

use InvalidArgumentException;


// Representa los datos mínimos de un producto que el contexto de Orden necesita.

final class ProductDataForOrder
{
    private int $productId;
    private string $name;
    private float $price;

    public function __construct(int $productId, string $name, float $price)
    {
        if (empty($productId)) {
            throw new InvalidArgumentException("Product ID cannot be empty.");
        }
        if ($price < 0) {
            throw new InvalidArgumentException("El Precio no puede ser.");
        }
        if (strlen($name) < 3) {
            throw new InvalidArgumentException("El Nombre debe tener al menos Tres caracteres");
        }
        $this->productId = $productId;
        $this->price = $price;
        $this->name = $name;
    }

    public function productId(): int
    {
        return $this->productId;
    }

    public function price(): float
    {
        return $this->price;
    }

        public function name(): string
    {
        return $this->name;
    }
}