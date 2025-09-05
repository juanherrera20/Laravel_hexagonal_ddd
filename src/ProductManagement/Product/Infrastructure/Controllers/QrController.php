<?php

namespace Src\ProductManagement\Product\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use InvalidArgumentException;
use Src\ProductManagement\Product\Application\GenerateProductQrUseCase;

class QrController
{
    public function __construct(
        private readonly GenerateProductQrUseCase $generateProductQrUseCase
    ) {}

    // public function generateQr(int $productId): Response
    // {
    //     try {
    //         // Obtienes los bytes binarios del QR
    //         $qrContent = $this->generateProductQrUseCase->execute($productId);

    //         // Devolver como imagen
    //         return response($qrContent, 200)
    //             ->header('Content-Type', 'image/png')
    //             ->header('Content-Disposition', 'inline; filename="product-qr-code.png"');

            
    //     } catch (InvalidArgumentException $e) {
    //         return response($e->getMessage(), 404)
    //             ->header('Content-Type', 'text/plain');
    //     }
    // }

    public function generateQr(int $productId): JsonResponse
    {
        try {
            $qrUrl = $this->generateProductQrUseCase->execute($productId);

            return response()->json([
                'qr_url' => $qrUrl
            ]);

        } catch (InvalidArgumentException $e) {
            return response()->json($e->getMessage(), 404)
                ->header('Content-Type', 'text/plain');
        }
    }

}