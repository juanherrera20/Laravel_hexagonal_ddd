<?php

namespace Src\ProductManagement\Product\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\ProductManagement\Product\Application\CreateProductUseCase;
use Src\ProductManagement\Product\Application\ListProductsUseCase;
use Src\ProductManagement\Product\Application\GetProductByIdUseCase;
use Src\ProductManagement\Product\Application\UpdateProductUseCase;
use Src\ProductManagement\Product\Application\DeleteProductUseCase;

class ProductController extends Controller
{
    public function __construct(
        private CreateProductUseCase $createProductUseCase,
        private ListProductsUseCase $listProductsUseCase,
        private GetProductByIdUseCase $getProductUseCase,
        private UpdateProductUseCase $updateProductUseCase,
        private DeleteProductUseCase $deleteProductUseCase
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['category', 'order']);
        $products = $this->listProductsUseCase->execute($filters);
        
        return $products;
    }

    public function show(int $id)
    {
        $product = $this->getProductUseCase->execute($id);

        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return $product;
        // return response()->json($this->formatProduct($product));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|min:3',
            'category' => 'required|string',
            'price'    => 'required|numeric|min:0'
        ]);

        $product = $this->createProductUseCase->execute(
            $validated['name'],
            $validated['category'],
            $validated['price']
        );

        return response()->json(['productId' => $product->value()], 201);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name'     => 'required|string|min:3',
            'category' => 'required|string',
            'price'    => 'required|numeric|min:0'
        ]);

        $product = $this->updateProductUseCase->execute(
            $id,
            $validated['name'],
            $validated['category'],
            $validated['price']
        );

        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json($this->formatProduct($product));
    }

    public function destroy(int $id)
    {
        $deleted = $this->deleteProductUseCase->execute($id);

        return $deleted
            ? response()->json(null, 204)
            : response()->json(['error' => 'Producto no encontrado'], 404);
    }

    /**
     *Convierte una entidad Product a array listo para JSON
     */
    // private function formatProduct($product): array
    // {
    //     return [
    //         'id'       => $product->id()->value(),
    //         'name'     => $product->name()->value(),
    //         'category' => $product->category()->value(),
    //         'price'    => $product->price()->value()
    //     ];
    // }
}
