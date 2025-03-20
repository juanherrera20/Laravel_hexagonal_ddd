<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Customer::factory(10)->create();
        Product::factory(20)->create();
        Order::factory(25)->create()->each(function ($order) {
            $order->products()->attach(
                Product::inRandomOrder()->limit(3)->pluck('id')->toArray(),
                ['quantity' => fake()->numberBetween(1, 5)]
            );

            $order->update([
                'shipping_address' => fake()->address(),
                'shipped_at' => fake()->optional()->dateTimeThisMonth(),
            ]);
        });
    }
}
