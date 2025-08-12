<?php

namespace Src\ProductManagement\Product\Application;

use Src\ProductManagement\Product\Domain\Contract\ProductRepositoryInterface;
use Src\ProductManagement\Product\Domain\Entities\Product;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductName;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductCategory;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductPrice;

class CreateProductUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function execute(int $id, string $name, string $category, float $price): Product
    {
        $product = new Product(
            id: $id,
            name: new ProductName($name),
            category: new ProductCategory($category),
            price: new ProductPrice($price)
        );

        return $this->productRepository->create($product);
    }
}
