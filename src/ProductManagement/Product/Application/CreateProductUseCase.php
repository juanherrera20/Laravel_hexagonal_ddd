<?php

namespace Src\ProductManagement\Product\Application;

use Src\ProductManagement\Product\Domain\Contract\ProductRepositoryInterface;



use Src\ProductManagement\Product\Domain\Entities\Product;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductName;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductCategory;
// use Src\ProductManagement\Product\Domain\ValueObjects\ProductId;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductPrice;

class CreateProductUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function execute(string $name, string $category, float $price)
    {
        $product = new Product(
            // id: null, //its not necessary
            name: new ProductName($name),
            category: new ProductCategory($category),
            price: new ProductPrice($price)
        );

        return $this->productRepository->create($product);
    }
}
