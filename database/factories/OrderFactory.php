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
            $products = Product::inRandomOrder()->limit(3)->get();

            $total = 0;
            foreach ($products as $product) {
                $quantity = fake()->numberBetween(1, 5); // Cantidad aleatoria entre 1 y 5
                $order->products()->attach($product->id, ['quantity' => $quantity]);

                $total += $product->price * $quantity;
            }

            $order->update(['total' => $total]);
        });
    }
}
