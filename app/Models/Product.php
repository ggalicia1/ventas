<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'stock', 'category_id', 'supplier', 'barcode',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /* public function addStock(int $quantity)
    {
        $this->increment('stock', $quantity);
    } */

    public function stockHistory()
    {
        return $this->hasMany(ProductStockHistory::class);
    }
    public function addStock(int $quantity, float $purchasePrice, float $salePrice, $expirationDate = null)
    {
        // Registrar en el historial
        $this->stockHistory()->create([
            'quantity' => $quantity,
            'purchase_price' => $purchasePrice,
            'sale_price' => $salePrice,
            'date_added' => now(),
            'expiration_date' => $expirationDate,
        ]);

        // Actualizar el stock total
        $this->increment('stock', $quantity);

        // Opcional: Actualizar el precio de venta actual
        $this->price = $salePrice;
        $this->save();
    }

    /**
     * Reducir stock
     */
    public function reduceStock(int $quantity)
    {
        if ($this->stock < $quantity) {
            throw new \Exception('Stock insuficiente');
        }
        $this->decrement('stock', $quantity);
    }
    
}
