<?php

namespace Src\ProductManagement\Product\Infrastructure\DTO;

use App\Models\Product as ProductEloquent;
use JsonSerializable;

final class ProductDto implements JsonSerializable 
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $category,
        public readonly float $price
    )
    { }
    
    // To Create new instance by model eloquent
    public static function fromEloquent(ProductEloquent $model): self
    {
        return new self(
            $model->id,
            $model->name,
            $model->category,
            $model->price
        );
    }

    // Mapping lists of products (Eloquent Model)
    public static function collection(iterable $products): array
    {
        return array_map(fn ($product) => self::fromEloquent($product), $products);
    }

    
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}