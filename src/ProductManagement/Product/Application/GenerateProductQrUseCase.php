<?php

declare(strict_types=1);

namespace Src\ProductManagement\Product\Application;


use Src\ProductManagement\Product\Domain\Contract\QrGeneratorInterface;
use InvalidArgumentException;
use Src\ProductManagement\Product\Domain\Contract\ProductRepositoryInterface;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductId;

final class GenerateProductQrUseCase
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly QrGeneratorInterface $qrGenerator,
    ) {}

   
    public function execute(int $productId): string
    {
        $product = $this->productRepository->findById(new ProductId($productId));

        if (!$product) {
            throw new InvalidArgumentException("Product with ID {$productId} not found.");
        }

        // Creamos un array con los datos que queremos
        $productData = [
            "id" => $product->id,
            "name" => $product->name,
            "category" => $product->category,
            "price" => $product->price
        ];
        
        // Convertimos el array a una cadena de texto JSON
        $jsonData = json_encode($productData);

        // Pasamos la cadena JSON al generador de QR
        return $this->qrGenerator->generate($jsonData);
    }

}