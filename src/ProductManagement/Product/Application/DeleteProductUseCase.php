<?php

namespace Src\ProductManagement\Product\Application;


use Src\ProductManagement\Product\Domain\Contract\ProductRepositoryInterface;
// use src\ProductManagement\Product\Domain\Entities\Product;

class DeleteProductUseCase
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {}

    public function execute(int $id): bool
    {
        return $this-> productRepository -> delete($id);
    }
}