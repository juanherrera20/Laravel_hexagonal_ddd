<?php
namespace Src\ProductManagement\Product\Infrastructure\Services;

use Illuminate\Support\Facades\Http;
use Src\ProductManagement\Product\Domain\Contract\QrGeneratorInterface;
use InvalidArgumentException;

class GoQrGenerator implements QrGeneratorInterface
{
    private const API_URL = 'https://api.qrserver.com/v1/create-qr-code/';


    // public function generate(string $data): string
    // {
    //     $response = Http::withOptions(['stream' => true])->get(self::API_URL, [
    //         'data' => $data,
    //         'size' => '300x300',
    //         'format' => 'png'
    //     ]);

    //     if (!$response->successful()) {
    //         throw new InvalidArgumentException("Error al generar el código QR. Código: " . $response->status());
    //     }

    //     file_put_contents(storage_path('app/test-qr.png'), $response->body());
    //     return $response->body(); // binario crudo PNG
    // }

    public function generate(string $data): string
    {
        // Generamos la URL del QR (el navegador la usará en el <img>)
        return self::API_URL . '?data=' . urlencode($data) . '&size=300x300&format=png';
    }

}