<?php
declare(strict_types=1);

namespace Src\OrderManagement\Order\Domain\ValueObjects;

use InvalidArgumentException;

final class OrderItemPrice
{
    public function __construct(float $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException("Order item Price no puede ser Negativo");
        }

        $this->value = $value;
    }

    public function value(): float
    {
        return $this->value;
    }
}
