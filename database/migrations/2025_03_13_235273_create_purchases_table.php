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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id'); // ID del proveedor
            $table->date('date'); // Fecha del ingreso
            $table->unsignedBigInteger('user_id'); // ID del usuario
            $table->string('receipt_type'); // Tipo de comprobante
            $table->string('receipt_number'); // Número de comprobante
            $table->string('receipt_series'); // Serie del comprobante
            $table->decimal('total', 10, 2); // Total
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending'); // Estado
            $table->timestamps();

            // Relaciones
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
