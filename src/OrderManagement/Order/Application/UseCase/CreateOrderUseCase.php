<?php

declare(strict_types=1);

namespace Src\OrderManagement\Order\Application\UseCase;

use InvalidArgumentException;
use Src\OrderManagement\Order\Domain\ValueObjects\CustomerId;
use Src\OrderManagement\Order\Domain\Contracts\OrderRepositoryInterface;
use Src\OrderManagement\Order\Domain\Contracts\ProductLookupServiceInterface; 
use Src\OrderManagement\Order\Domain\Entities\Order as DomainOrder; 
use Src\OrderManagement\Order\Domain\Entities\OrderItem as DomainOrderItem; 
use Src\OrderManagement\Order\Domain\ValueObjects\OrderShippingAddress; 
use Src\OrderManagement\Order\Domain\ValueObjects\OrderId; 
use Src\OrderManagement\Order\Domain\ValueObjects\OrderStatus; 
use Src\OrderManagement\Order\Domain\ValueObjects\OrderTotal; 

// Value Objects usados para crear OrderItem
use Src\ProductManagement\Product\Domain\ValueObjects\ProductId as ProductContextProductId; // Alias para ProductId del contexto Product
use Src\OrderManagement\Order\Domain\ValueObjects\OrderItemQuantity;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderItemPrice;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderItemName; // Para usar el nombre del producto en OrderItem


final class CreateOrderUseCase // Si implementa una interfaz, debe declararlo aquí
{
    private OrderRepositoryInterface $orderRepository;
    private ProductLookupServiceInterface $productLookupService;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductLookupServiceInterface $productLookupService,
    ) {
        $this->orderRepository = $orderRepository;
        $this->productLookupService = $productLookupService;
    }

    public function execute(int $customerIdValue, string $shippingAddressValue, array $productsData): array
    {
        // Convertir valores primitivos de entrada a Value Objects para validación
        $customerId = new CustomerId($customerIdValue);
        $shippingAddress = new OrderShippingAddress($shippingAddressValue);

        if (empty($productsData)) {
            throw new InvalidArgumentException("Order Debe tener al menos un Producto.");
        }

        $orderItems = [];
        $calculatedOrderTotal = 0.0; // ¡Aquí el caso de uso calculará el total!
        
        // 2. Procesar y validar los productos, y construir las instancias de OrderItem
        foreach ($productsData as $productData) {
            $productIdValue = (int) $productData['product_id']; // Asegurar string para ProductId VO
            $quantityValue = (int) $productData['quantity'];

            $productContextProductId = new ProductContextProductId($productIdValue); 
            $quantity = new OrderItemQuantity($quantityValue);

            // Llamada al servicio de búsqueda de producto (ACL) para obtener los datos necesarios (ProductDataForOrder)
            $productDataForOrder = $this->productLookupService->getProductDataForOrder($productContextProductId->value());
            
            if (!$productDataForOrder) {
                throw new InvalidArgumentException("Producto con ID {$productContextProductId->value()} no encontrado o no válido.");
            }

            $itemPrice = new OrderItemPrice($productDataForOrder->price()); 
            $itemName = new OrderItemName($productDataForOrder->name());

        
            $orderItem = DomainOrderItem::create(
                $productContextProductId, 
                $quantity,                
                $itemPrice,               
                $itemName                 
            );
            
            // 4. Calcular el subtotal de cada OrderItem directamente en el Caso de Uso
            $itemSubtotalValue = $quantity->value() * $itemPrice->value();
            
            $orderItems[] = $orderItem; // Agregamos el OrderItem anémico a la lista
            $calculatedOrderTotal += $itemSubtotalValue; // Sumamos al total de la orden
        }

        $orderStatus = new OrderStatus('pending'); // Estado inicial
        $orderTotal = new OrderTotal($calculatedOrderTotal); // Total calculado en el Use Case

        $order = new DomainOrder(
            null,
            $customerId,
            $orderItems, // Pasa el array de OrderItem[]
            $orderStatus,
            $shippingAddress,
            null, // shippedAt (null inicialmente)
            $orderTotal, // Pasa el total calculado
        );
        

        return $this->orderRepository->create($order);
    }
}