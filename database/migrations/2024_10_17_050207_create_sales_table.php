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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->useCurrent(); // Fecha y hora de la venta
            $table->decimal('total_amount', 10, 2); // Monto total de la venta
            $table->foreignId('customer_id')->nullable(); // Clave foránea (opcional)
            $table->timestamps(); // created_at y updated_at
            //$table->decimal('total_amount', 10, 2);
            $table->string('payment_method');
            $table->decimal('cash_amount', 10, 2)->nullable();
            $table->decimal('change_amount', 10, 2)->nullable();
            $table->string('card_reference')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
