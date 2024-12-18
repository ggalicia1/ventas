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
        Schema::create('product_stock_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relación con el producto
            $table->integer('quantity'); // Cantidad de stock añadida
            $table->integer('remaining_quantity')->nullable(); // Cantidad de stock añadida
            $table->date('date_added'); // Fecha de ingreso del stock
            $table->decimal('purchase_price', 8, 2); // Stock entry date
            $table->decimal('sale_price', 8, 2); // Fecha de ingreso del stock
            $table->date('expiration_date')->nullable(); // Fecha de vencimiento (opcional)
            $table->timestamps(); // Created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stock_history');
    }
};
