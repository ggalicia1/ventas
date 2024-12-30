<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsStockExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::with(['latestStockHistory'])
            ->get()
            ->map(function ($product) {
                $latestStock = $product->latestStockHistory;
                return [
                    'name' => $product->name,
                    'current_stock' => $product->stock,
                    'last_stock_quantity' => $latestStock->quantity ?? 'N/A',
                    'purchase_price' => $latestStock->purchase_price ?? 'N/A',
                    'sale_price' => $latestStock->sale_price ?? 'N/A',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Current Stock',
            'Last Stock Quantity',
            'Purchase Price',
            'Sale Price',
        ];
    }
}


