<?php

namespace Src\ProductManagement\Product\Domain\Contract;

use Src\ProductManagement\Product\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    public function create(Product $product): Product;

    public function findById(int $id): ?Product;

    public function list(array $filters = [], /*string $orderBy = 'price', string $order = 'asc'*/): array;

    public function update(int $id, Product $product): ?Product;

    public function delete(int $id): bool;
}
