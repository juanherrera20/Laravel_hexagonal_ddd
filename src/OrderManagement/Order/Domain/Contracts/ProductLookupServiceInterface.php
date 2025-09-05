<?php

declare(strict_types=1);

namespace Src\OrderManagement\Order\Domain\Contracts;

use Src\OrderManagement\Order\Domain\ValueObjects\ProductDataForOrder;

interface ProductLookupServiceInterface
{
    public function getProductDataForOrder(int $productId): ?ProductDataForOrder;
}
