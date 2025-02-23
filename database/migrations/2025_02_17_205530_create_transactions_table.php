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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('description');
            $table->decimal('debit_balance', 10, 2)->default(0);
            $table->decimal('change_amount', 10, 2)->default(0);
            $table->decimal('changed_balance', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->boolean('cleared')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
