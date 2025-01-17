<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Database\Query\Builder as QueryBuilder;


class ExportController extends Controller
{
    public function exportProductsStock()
    {
        $products = Product::with('stockHistory')
        ->get();

        $filePath = storage_path('app/public/exports/products.xlsx');

        $writer = SimpleExcelWriter::create($filePath);

        foreach ($products as $product) {
            //dd($product->stockHistory->first());
            /* $stockHistory= $product->stockHistory->first();
            dd($product); */
            $latestStock = $product->stockHistory->first();
            //dd($latestStock);
            $writer->addRow([
                'Nombre'              => $product->name,
                'Stock'             => $product->stock,
                'Precio'             => $product->price,
                'Ultimo historial Stock'      => $latestStock->remaining_quantity ?? 'N/A',
                'Precio de Compra'     => $latestStock->purchase_price ?? 'N/A',
                'Precio de venta historial Stock' => $latestStock->sale_price ?? 'N/A',
                'Fecha de vencimiento'    => $latestStock->expiration_date ?? 'N/A',
            ]);
        }

        return response()->download($filePath)->deleteFileAfterSend();
    }
}
