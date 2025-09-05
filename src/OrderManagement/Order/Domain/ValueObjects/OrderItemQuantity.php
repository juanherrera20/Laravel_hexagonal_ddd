<?php
declare(strict_types=1);

namespace Src\OrderManagement\Order\Domain\ValueObjects;

use InvalidArgumentException;

final class OrderItemQuantity
{
    public function __construct(private int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("Order item quantity must be positive.");
        }
    }

    public function value(): int
    {
        return $this->value;
    }

}
