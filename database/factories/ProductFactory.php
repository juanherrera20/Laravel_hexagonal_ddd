<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->regexify('[A-Za-z]{3,15}'),
            'category' => fake()->randomElement(['Electronics', 'Clothing', 'Books']),
            'price' => fake()->randomFloat(2, 10, 1000)
        ];
    }
}
