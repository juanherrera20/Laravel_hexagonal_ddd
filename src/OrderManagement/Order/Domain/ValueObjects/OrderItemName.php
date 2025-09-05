<?php
declare(strict_types=1);

namespace Src\OrderManagement\Order\Domain\ValueObjects;

use InvalidArgumentException;

final class OrderItemName
{
    public function __construct(private string $value)
    {
        if (strlen($value) < 3) {
            throw new InvalidArgumentException("El nombre no puede ser inferior a tres caracteres");
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
