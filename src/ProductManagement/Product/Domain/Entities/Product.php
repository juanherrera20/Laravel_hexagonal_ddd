<?php

namespace Src\ProductManagement\Product\Domain\Entities;

// use Src\ProductManagement\Product\Domain\ValueObjects\ProductId;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductName;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductCategory;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductPrice;

class Product
{
    // private ?ProductId $id;
    private ProductName $name;
    private ProductCategory $category;
    private ProductPrice $price;

    public function __construct(
        // ?ProductId $id,
        ProductName $name,
        ProductCategory $category,
        ProductPrice $price
    ) {
        // $this->id       = $id;
        $this->name     = $name;
        $this->category = $category;
        $this->price    = $price;
    }

    // public function id(): ProductId
    // {
    //     return $this->id;
    // }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function category(): ProductCategory
    {
        return $this->category;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }
}
