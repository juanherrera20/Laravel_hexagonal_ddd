<?php
declare(strict_types=1);

namespace Src\OrderManagement\Order\Domain\ValueObjects;

use InvalidArgumentException;

final class OrderTotal
{
    public function __construct(private float $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException("Order total cannot be negative");
        }
    }

    public function value(): float
    {
        return $this->value;
    }
}
