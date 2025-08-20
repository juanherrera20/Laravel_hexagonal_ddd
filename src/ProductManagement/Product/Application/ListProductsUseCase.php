<?php

namespace Src\ProductManagement\Product\Application;

use Src\ProductManagement\Product\Domain\Contract\ProductRepositoryInterface;

class ListProductsUseCase
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {}

    public function execute(array $filters): array
    {
        return $this-> productRepository -> list($filters);
    }
}