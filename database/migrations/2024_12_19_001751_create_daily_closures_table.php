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
        Schema::create('daily_closures', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // 'fecha' -> 'date'
            $table->decimal('cash_sales_total', 10, 2); // 'total_ventas_efectivo' -> 'cash_sales_total'
            $table->integer('cash_sales_quantity'); // 'cantidad_productos_efectivo' -> 'cash_sales_quantity'
            $table->decimal('card_sales_total', 10, 2); // 'total_ventas_tarjeta' -> 'card_sales_total'
            $table->integer('card_sales_quantity'); // 'cantidad_productos_tarjeta' -> 'card_sales_quantity'
            $table->decimal('total_sales', 10, 2); // 'total_ventas' -> 'total_sales'
            $table->integer('total_products_sold'); // 'cantidad_productos_vendidos' -> 'total_products_sold'
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_closures');
    }
};
