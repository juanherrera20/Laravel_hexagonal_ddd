<?php

namespace Src\ProductManagement\Product\Application;


use Src\ProductManagement\Product\Domain\Contract\ProductRepositoryInterface;
use Src\ProductManagement\Product\Domain\Entities\Product;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductId;

class GetProductByIdUseCase
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {}

    public function execute(int $id)  //: ? Product
    {
        return $this-> productRepository -> findById(new ProductId($id));
    }
}