<?php
declare(strict_types=1);

namespace Src\OrderManagement\Order\Domain\ValueObjects;

use InvalidArgumentException;

final class OrderShippingAddress
{
    public function __construct(private string $value)
    {
        if (trim($value) === '') {
            throw new InvalidArgumentException("Shipping address cannot be empty");
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
