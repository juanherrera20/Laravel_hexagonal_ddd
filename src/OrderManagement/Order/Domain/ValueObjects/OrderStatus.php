<?php
declare(strict_types=1);

namespace Src\OrderManagement\Order\Domain\ValueObjects;

use InvalidArgumentException;

final class OrderStatus
{
    private const ALLOWED = ['pending', 'processing', 'declined','completed'];

    public function __construct(private string $value)
    {
        if (!in_array($value, self::ALLOWED, true)) {
            throw new InvalidArgumentException("Invalid order status: $value");
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
