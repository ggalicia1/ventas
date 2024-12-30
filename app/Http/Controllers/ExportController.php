<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Spatie\SimpleExcel\SimpleExcelWriter;


class ExportController extends Controller
{
    public function exportProductsStock()
    {
        $products = Product::with(['stockHistory' => function ($query) {
            $query->latest('date_added')->first();
        }])->get();

        $filePath = storage_path('app/public/exports/products.xlsx');

        $writer = SimpleExcelWriter::create($filePath);

        foreach ($products as $product) {
            $latestStock = $product->stockHistory->first();

            $writer->addRow([
                'Name'              => $product->name,
                'Stock'             => $product->stock,
                'PurchasePrice'     => $latestStock->purchase_price ?? 'N/A',
                'SalePrice'         => $latestStock->sale_price ?? 'N/A',
                'ExpirationDate'    => $latestStock->expiration_date ?? 'N/A',
            ]);
        }

        return response()->download($filePath)->deleteFileAfterSend();
    }
}
