<?php

declare(strict_types=1);

namespace Src\OrderManagement\Order\Application\DTO;

use JsonSerializable;
use Src\OrderManagement\Order\Domain\Entities\OrderItem as DomainOrderItem;

final class OrderItemDto implements JsonSerializable
{
    public function __construct(
        public readonly int $productId,
        public readonly string $product_name,
        public readonly float $price_at_order,
        public readonly int $quantity
    ) {
    }

    public static function fromDomainEntity(DomainOrderItem $item): self
    {
        return new self(
            $item->productId()->value(),
            $item->name()->value(),
            $item->price()->value(),
            $item->quantity()->value()
        );
    }
    
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}