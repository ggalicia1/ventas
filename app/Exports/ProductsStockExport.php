<?php
namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsStockExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::query()
            ->join('product_stock_history', 'products.id', '=', 'product_stock_history.product_id')
            ->select([
                'products.name as product_name',
                'products.stock as current_stock',
                'product_stock_history.quantity as last_stock_quantity',
                'product_stock_history.purchase_price',
                'product_stock_history.sale_price',
            ])
            ->orderBy('product_stock_history.date_added', 'desc')
            ->get();
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
