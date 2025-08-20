<?php

namespace Src\ProductManagement\Product\Domain\Contract;

use Src\ProductManagement\Product\Domain\Entities\Product;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductId;

interface ProductRepositoryInterface
{
    public function create(Product $product);

    public function findById(ProductId $id);//: ?Product;

    public function list(array $filters = []): array;

    public function update(int $id, Product $product);//: ?Product;  

    public function delete(int $id): bool;
}
