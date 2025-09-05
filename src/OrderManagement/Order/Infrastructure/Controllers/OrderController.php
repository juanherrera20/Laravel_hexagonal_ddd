<?php

namespace Src\OrderManagement\Order\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Asumiendo que usas el base Controller de Laravel
use App\Http\Requests\OrderPostRequest;

use InvalidArgumentException; // Para manejar excepciones de dominio
use Src\OrderManagement\Order\Application\DTO\OrderDto;
use Src\OrderManagement\Order\Application\UseCase\CalculateTotalSpentCustomerUseCase;
use Src\OrderManagement\Order\Application\UseCase\CreateOrderUseCase;
use Src\OrderManagement\Order\Application\UseCase\GetOrdersByCustomerUseCase;

class OrderController extends Controller
{
    private CreateOrderUseCase $createOrderUseCase; // Inyectamos la interfaz
    private GetOrdersByCustomerUseCase $getOrdersByCustomerUseCase;
    private CalculateTotalSpentCustomerUseCase $totalSpentCustomerUseCase;

    public function __construct(
        CreateOrderUseCase $createOrderUseCase, // Inyectamos la interfaz
        GetOrdersByCustomerUseCase $getOrdersByCustomerUseCase,
        CalculateTotalSpentCustomerUseCase $totalSpentCustomerUseCase,

    ) {
        $this->createOrderUseCase = $createOrderUseCase;
        $this->getOrdersByCustomerUseCase = $getOrdersByCustomerUseCase;
        $this->totalSpentCustomerUseCase = $totalSpentCustomerUseCase;
    
    }

    public function store(OrderPostRequest $request): JsonResponse
    {
        try {

            $validated = $request->validated();
            // El caso de uso devuelve un array con los datos que necesitamos
            $responseArray = $this->createOrderUseCase->execute(
                $validated['customer_id'],
                $validated['shipping_address'],
                $validated['products']
            );

            // Devolvemos la respuesta directamente del array generado por el caso de uso
            return response()->json($responseArray, 201);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    // Maneja la HU-10: Ver el historial de órdenes de un cliente.
    public function indexByCustomer(int $customerId, Request $request): JsonResponse
    {
        try {
            // El caso de uso devuelve un paginador de entidades de dominio
            $Orders = $this->getOrdersByCustomerUseCase->execute($customerId);
            
            // Mapear los ítems del paginador a DTOs
            $dtos = OrderDto::collection($Orders);
            
            // Devolver la respuesta paginada con los DTOs y metadatos
            return response()->json($dtos,200);

        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Calculate the total amount spent by a specific customer.
     */
    public function totalSpentByCustomer(int $customerId): JsonResponse
    {
        try {
            $totalSpent = $this->totalSpentCustomerUseCase->execute($customerId);

            return response()->json($totalSpent, 200);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}