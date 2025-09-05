<?php
declare(strict_types=1);

namespace Src\OrderManagement\Order\Domain\Entities;

use Src\OrderManagement\Order\Domain\ValueObjects\OrderItemName;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductId; // Asume ProductId del contexto ProductManagement
use Src\OrderManagement\Order\Domain\ValueObjects\OrderItemQuantity;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderItemPrice; // Precio del producto en el momento de la compra

final class OrderItem
{
    private ProductId $productId;
    private OrderItemQuantity $quantity;
    private OrderItemPrice $price; // Precio unitario del producto en el momento de la orden
    private OrderItemName $name; // ¡Nueva propiedad!

    public function __construct(
        ProductId $productId,
        OrderItemQuantity $quantity,
        OrderItemPrice $price,
        OrderItemName $name // ¡Nuevo argumento!
    ) {
        $this->productId = $productId;
        $this->quantity  = $quantity;
        $this->price     = $price;
        $this->name      = $name;
    }

    public static function create(ProductId $productId, OrderItemQuantity $quantity, OrderItemPrice $price, OrderItemName $name): self
    {
        return new self($productId, $quantity, $price, $name);
    }

    // Getters para los Value Objects
    public function productId(): ProductId { return $this->productId; }
    public function quantity(): OrderItemQuantity { return $this->quantity; }
    public function price(): OrderItemPrice { return $this->price; }
    public function name(): OrderItemName { return $this->name; }

    // En un dominio anémico estricto, el método subtotal() no estaría aquí.
    // La lógica de cálculo del subtotal se realizaría en el caso de uso.
    
    // Método de dominio: calcula el subtotal de este item
    // public function subtotal(): OrderItemSubtotal
    // {
    //     $subtotalValue = $this->quantity->value() * $this->price->value();
    //     return new OrderItemSubtotal($subtotalValue);
    // }

}
