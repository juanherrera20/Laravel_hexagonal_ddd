<?php

declare(strict_types=1);

namespace Src\OrderManagement\Order\Domain\Entities;

use Src\OrderManagement\Order\Domain\ValueObjects\OrderId;
use Src\OrderManagement\Order\Domain\ValueObjects\CustomerId;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderStatus;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderShippingAddress;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderTotal;
use DateTimeImmutable;
use DomainException;

final class Order
{
    private ?OrderId $id;
    private CustomerId $customerId;
    /** @var OrderItem[] */
    private array $items;
    private OrderStatus $status;
    private ?OrderShippingAddress $shippingAddress;
    private ?DateTimeImmutable $shippedAt;
    private OrderTotal $total; // Ya no es nullable, debe ser provisto al crear

    public function __construct(
        ?OrderId $id, 
        CustomerId $customerId,
        array $items,
        OrderStatus $status, 
        OrderShippingAddress $shippingAddress, 
        ?DateTimeImmutable $shippedAt,
        OrderTotal $total, 
    ) {
        if (empty($items)) {
            throw new DomainException("Order must have at least one item");
        }

        $this->id              = $id;
        $this->customerId      = $customerId;
        $this->items           = $items;
        $this->status          = $status;
        $this->shippingAddress = $shippingAddress;
        $this->shippedAt       = $shippedAt;
        $this->total           = $total;
    }

    // ---- Getters para los Value Objects
    public function id(): OrderId { return $this->id; }
    public function customerId(): CustomerId { return $this->customerId; }
    /** @return OrderItem[] */
    public function items(): array { return $this->items; }
    public function status(): OrderStatus { return $this->status; }
    public function shippingAddress(): ?OrderShippingAddress { return $this->shippingAddress; }
    public function shippedAt(): ?DateTimeImmutable { return $this->shippedAt; }
    public function total(): OrderTotal { return $this->total; } // Getter simple, no calcula
   

    // En un dominio anémico estricto, los métodos de comportamiento como addItem, calculateTotal,
    // ship, cancel, setItems no estarían aquí. La lógica de estado y cálculo
    // sería responsabilidad del caso de uso.


       // Getter para el total (calcula si no está cacheado)
    // public function total(): OrderTotal
    // {
    //     if ($this->total === null) {
    //         $sum = 0.0;
    //         foreach ($this->items as $item) {
    //             $sum += $item->subtotal()->value(); // Asume OrderItem tiene subtotal() que devuelve un ValueObject
    //         }
    //         $this->total = new OrderTotal($sum);
    //     }
    //     return $this->total;
    // }

    // // ---- Métodos de dominio (reglas de negocio)
    // public function addItem(OrderItem $item): void
    // {
    //     $this->items[] = $item;
    //     $this->total = null; // Invalida el caché del total para que se recalcule
    // }

    // public function ship(DateTimeImmutable $date): void
    // {
    //     if ($this->shippingAddress === null) {
    //         throw new DomainException("Order cannot be shipped without a shipping address.");
    //     }
    //     if ($this->status->value() === 'shipped') {
    //         throw new DomainException("Order is already shipped.");
    //     }
    //     $this->status = new OrderStatus("shipped");
    //     $this->shippedAt = $date;
    // }

    // public function cancel(): void
    // {
    //     if ($this->status->value() === 'completed') {
    //         throw new DomainException("Cannot cancel a shipped order.");
    //     }
    //     $this->status = new OrderStatus("declined");
    // }

    // // Opcional: Para permitir la carga de items desde el repositorio
    // public function setItems(array $items): void
    // {
    //     $this->items = $items;
    //     $this->total = null; // Invalida el caché
    // }
    
}