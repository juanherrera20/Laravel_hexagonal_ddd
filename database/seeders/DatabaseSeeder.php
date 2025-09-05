<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Customer::factory(10)->create();
        Product::factory(20)->create();

        // Crear 25 órdenes. El OrderFactory ya se encarga de adjuntar los productos
        // con los datos de snapshot y de calcular el total.
        Order::factory(20)->create();
    }
}