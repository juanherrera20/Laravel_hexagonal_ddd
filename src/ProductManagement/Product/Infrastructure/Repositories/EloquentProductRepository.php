<?php

declare(strict_types=1);

namespace Src\ProductManagement\Product\Infrastructure\Repositories;

use App\Models\Product as ProductEloquent;
use InvalidArgumentException;
use Src\ProductManagement\Product\Domain\Contract\ProductRepositoryInterface;

use Src\ProductManagement\Product\Infrastructure\DTO\ProductDto;

// Entity Product from Domain
use Src\ProductManagement\Product\Domain\Entities\Product;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductId;
// use Src\ProductManagement\Product\Domain\ValueObjects\ProductName;
// use Src\ProductManagement\Product\Domain\ValueObjects\ProductCategory;
// use Src\ProductManagement\Product\Domain\ValueObjects\ProductPrice;


class EloquentProductRepository implements ProductRepositoryInterface
{
    public function create(Product $product)
    {
        $data = ["name"=>$product->name()->value(), "category"=>$product->category()->value(), "price"=>$product->price()->value()];
        $productCreate = ProductEloquent::create($data);
    
        return new ProductId($productCreate->id);
    }

    public function findById(ProductId $id)//: ?Product
    {
        $model = ProductEloquent::find($id->value());

        return ProductDto::fromEloquent($model);
    }


    // Falta Paginación !!!!!!!!!!!!!!!!!!!!!!!!!
    public function list(array $filters = []): array
    {
        $query = ProductEloquent::query();

        // Filtrar por categoría (exacta)
        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        // Orden por precio (asc|desc). Cualquier otro valor es asc
        if (!empty($filters['order'])) {
            $order = strtolower($filters['order']) === 'desc' ? 'desc' : 'asc';
            $query->orderBy('price', $order);
        } else {
            $query->orderBy('price', 'asc');
        }

        $products = $query->paginate(10); // colección paginada

        return [
            'data' => ProductDto::collection($products->items()),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'per_page'     => $products->perPage(),
                'total'        => $products->total(),
            ]
        ];
    }

    public function update(int $id, Product $product)//: ?Product
    {
        $model = ProductEloquent::find($id);
        if (!$model) {
            return null;
        }

        $model->name = $product->name()->value();
        $model->category = $product->category()->value();
        $model->price = $product->price()->value();
        $model->save();

        return ProductDto::fromEloquent($model);
    }

    public function delete(int $id): bool
    {
        $model = ProductEloquent::find($id);
        if (!$model) return false;
        return (bool) $model->delete();
    }


    // ancient method !!!

    // private function mapModelToEntity(ProductEloquent $model): Product
    // {
    //     try {
    //         return new Product(
    //             id:       new ProductId($model->id),
    //             name:     new ProductName($model->name),
    //             category: new ProductCategory($model->category),
    //             price:    new ProductPrice($model->price)
    //         );
    //     } catch (InvalidArgumentException $e) {
    //         // usar Categoría por Defecto si no se suministra una correctamente
    //         return new Product(
    //             id:       new ProductId($model->id),
    //             name:     new ProductName($model->name),
    //             category: new ProductCategory('Others'),
    //             price:    new ProductPrice($model->price)
    //         );
    //     }
    // }

}
