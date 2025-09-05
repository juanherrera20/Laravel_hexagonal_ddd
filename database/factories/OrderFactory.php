<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => fake()->randomFloat(0, 1, 10),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'declined']),
            'total' => null,
            'shipping_address' => fake()->address(),
            'shipped_at' => fake()->optional()->dateTimeThisMonth(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $products = Product::inRandomOrder()->limit(fake()->numberBetween(1, 3))->get(); // Cantidad de productos por orden

            $total = 0;
            $pivotData = []; // Para almacenar los datos del pivote

            foreach ($products as $product) {
                $quantity = fake()->numberBetween(1, 5); // Cantidad aleatoria entre 1 y 5
                
                $pivotData[$product->id] = [
                    'quantity' => $quantity,
                    'price_at_order' => $product->price, // <<-- ¡Precio del snapshot!
                    'name_at_order' => $product->name, // <<-- ¡Nombre del snapshot!
                ];

                $total += $product->price * $quantity;
            }
            
            // Adjuntar todos los productos de una vez
            $order->products()->attach($pivotData);

            // Actualizar el total de la orden
            $order->update(['total' => $total]);
        });
    }
}
