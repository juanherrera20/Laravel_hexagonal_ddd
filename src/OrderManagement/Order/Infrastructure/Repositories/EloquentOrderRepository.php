<?php

namespace Src\OrderManagement\Order\Infrastructure\Repositories;

use Src\OrderManagement\Order\Domain\Entities\Order as DomainOrder;
use Src\OrderManagement\Order\Domain\Entities\OrderItem as DomainOrderItem;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderId;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderStatus;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderTotal;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderShippingAddress;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderItemQuantity;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderItemPrice;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderItemName; // Para mapear el nombre en el pivote
use Src\OrderManagement\Order\Domain\ValueObjects\CustomerId;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductId; // Necesario para OrderItem

use App\Models\Order as EloquentOrderModel;
use DateTimeImmutable;
use Src\OrderManagement\Order\Domain\Contracts\OrderRepositoryInterface;

class EloquentOrderRepository implements OrderRepositoryInterface
{

    public function create(DomainOrder $domainOrder): array
    {
        $eloquentOrder = new EloquentOrderModel(); // Siempre creamos una nueva instancia

    
            $eloquentOrder->customer_id = $domainOrder->customerId()->value(); // Asume CustomerId VO devuelve int/string según DB
            $eloquentOrder->status = $domainOrder->status()->value();
            $eloquentOrder->shipping_address = $domainOrder->shippingAddress()?->value(); // Nullable
            $eloquentOrder->shipped_at = $domainOrder->shippedAt() ? $domainOrder->shippedAt()->format('Y-m-d H:i:s') : null; // Nullable
            $eloquentOrder->total = $domainOrder->total()->value(); // Total ya calculado por el Use Case
            
            $eloquentOrder->save(); // Guarda la orden principal en la base de datos

            $pivotData = [];
            foreach ($domainOrder->items() as $item) {
                $pivotData[$item->productId()->value()] = [ 
                    'quantity' => $item->quantity()->value(), 
                    'price_at_order' => $item->price()->value(),
                    'name_at_order' => $item->name()->value(),
                ];
            }
            // `sync` elimina los productos que no están en $pivotData y añade/actualiza los que sí.
            $eloquentOrder->products()->sync($pivotData);
   

        // Retornar el ID de la orden y un mensaje de éxito
        return [
            'order_id' => $eloquentOrder->id, // Ahora el ID de la orden ya está asignado
            'message' => 'Order Creada Exitosamente.'
        ];
    }

    //Traer un Registro Order
    public function findById(int $id): ?DomainOrder
    {
        $eloquentOrder = EloquentOrderModel::with('products')->find($id);

        if (!$eloquentOrder) {
            return null;
        }

        return $this->toDomainEntity($eloquentOrder);
    }

    //Traer todo el historial de un Customer
    public function findByCustomerId(int $customerId): array
    {
        $eloquentOrders = EloquentOrderModel::with('products')
                                            ->where('customer_id', $customerId)
                                            ->latest() // Ordenar por fecha de creación descendente
                                            ->paginate(10);
                                            // ->get();

        return $eloquentOrders->map(fn($order) => $this->toDomainEntity($order))->toArray();
    }

    public function delete(int $id): bool
    {
        $eloquentOrder = EloquentOrderModel::find($id);
        if ($eloquentOrder) {
            // Eliminar registros de la tabla pivote antes de eliminar la orden
            $eloquentOrder->products()->detach();
            $eloquentOrder->delete();

            return True;
        }

        return false;
    }

    /**
     * Convierte un modelo Eloquent de Order a una entidad de dominio Order.
     */
    private function toDomainEntity(EloquentOrderModel $eloquentOrder): DomainOrder
    {
        $items = [];
        foreach ($eloquentOrder->products as $eloquentProduct) {
            
            $items[] = DomainOrderItem::create( 
                new ProductId((string) $eloquentProduct->id), 
                new OrderItemQuantity((int) $eloquentProduct->pivot->quantity), 
                new OrderItemPrice((float) $eloquentProduct->pivot->price_at_order), 
                new OrderItemName((string) $eloquentProduct->pivot->name_at_order) 
            );
        }

        // Reconstruimos la entidad de dominio Order con todos los Value Objects necesarios
        $domainOrder = new DomainOrder(
            new OrderId((string) $eloquentOrder->id), // Mapeamos a OrderId VO (asume string ID)
            new CustomerId((int) $eloquentOrder->customer_id), // Mapeamos a CustomerId VO (asume string ID)
            $items, // Pasa los items al constructor
            new OrderStatus((string) $eloquentOrder->status),
            $eloquentOrder->shipping_address ? new OrderShippingAddress((string) $eloquentOrder->shipping_address) : null,
            $eloquentOrder->shipped_at ? new DateTimeImmutable($eloquentOrder->shipped_at) : null,
            new OrderTotal((float) $eloquentOrder->total), // Pasa el total cacheado de la DB
        );
        
        return $domainOrder;
    }
}