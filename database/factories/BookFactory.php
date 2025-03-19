<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake() -> sentence(),
            'description' => fake() -> paragraph(),
            'price' => fake() -> randomFloat(2, 10, 1000),
            'author_id' => fake() -> randomFloat(0, 1, 5)
        ];
    }
}
