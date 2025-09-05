<?php

declare(strict_types=1);

namespace Src\OrderManagement\Order\Application\DTO;

use JsonSerializable;
use DateTimeImmutable;
use Src\OrderManagement\Order\Domain\Entities\Order as DomainOrder;

final class OrderDto implements JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly int $customer_id,
        public readonly float $total,
        public readonly string $status,
        public readonly ?string $shipping_address,
        public readonly ?DateTimeImmutable $shipped_at,
        public readonly array $items
    ) {
    }

    public static function fromDomainEntity(DomainOrder $order): self
    {
        $items = array_map(
            fn ($item) => OrderItemDto::fromDomainEntity($item),
            $order->items()
        );

        return new self(
            $order->id()->value(),
            $order->customerId()->value(),
            $order->total()->value(),
            $order->status()->value(),
            $order->shippingAddress()?->value(),
            $order->shippedAt(),
            $items
        );
    }
    
    public static function collection(iterable $orders): array
    {
        return array_map(
            fn ($order) => self::fromDomainEntity($order),
            $orders
        );
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}