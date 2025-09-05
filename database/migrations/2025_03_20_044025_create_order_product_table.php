<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete('cascade');
            $table->foreignId('product_id')->constrained()->cascadeOnDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->float('price_at_order'); // <<-- ¡Columna añadida!
            $table->string('name_at_order'); // <<-- ¡Columna añadida!
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
