<?php

declare(strict_types=1);

namespace Src\OrderManagement\Order\Application\UseCase;

use Src\OrderManagement\Order\Domain\Contracts\OrderRepositoryInterface;

final class CalculateTotalSpentCustomerUseCase
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function execute(int $customerIdValue): array
    {
        $orders = $this->orderRepository->findByCustomerId($customerIdValue);
        
        $totalSpent = 0.0;
        foreach ($orders as $order) {
            // Se asume que el objeto Order tiene un método total() que devuelve el valor
         
            $totalSpent += $order->total()->value();
            
        }
        
        // 4. Preparar y devolver la respuesta con los detalles
        return [
            'customer_id' => $customerIdValue,
            'total_spent' => round($totalSpent,2),
            'total_orders' => count($orders) // Si quieres, puedes contar el total de órdenes en la página
        ];
    }

}
