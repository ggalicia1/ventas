<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\DailyClosureController;
use App\Http\Controllers\TransactionController;


require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Rutas para Categorías
    Route::resource('categories', CategoryController::class);
    
    // Rutas para Productos
    Route::resource('products', ProductController::class);
    
    // Si quieres añadir una ruta para buscar productos:
    Route::get('/products/search/{search}', [ProductController::class, 'search'])->name('products.search');
    
    Route::get('/products/barcode/{barcode}', [ProductController::class, 'findByBarcode']);
    Route::get('products/{id}/add-stock', [ProductController::class, 'showAddStockForm'])->name('products.addStock');
    Route::post('products/{id}/add-stock', [ProductController::class, 'addProductStock'])->name('products.addStock.post');
    Route::post('products/masive-stock', [ProductController::class, 'storeMassiveProducts'])->name('products.store.massive');
    Route::delete('products/delete-stock/{id}', [ProductController::class, 'deleteStockHistory'])->name('products.stock.delete');
    Route::get('/products/{id}/edit-stock', [ProductController::class, 'edit_stock'])->name('products.stock.edit');
    Route::put('/products/{id}/edit-stock', [ProductController::class, 'update_stock'])->name('products.stock.update');

    
    
    Route::get('sales/close', [SaleController::class, 'closeSales'])->name('sales.close');
    Route::post('/sales-close', [SaleController::class, 'dailyClosure']);
    Route::resource('sales', SaleController::class);
    Route::get('sales/{id}/receipt', [SaleController::class, 'generateReceipt'])->name('sales.receipt');

    Route::get('/daily-closures', [DailyClosureController::class, 'index'])->name('daily-closures.index');
    Route::get('/daily-closures/create', [DailyClosureController::class, 'create'])->name('daily-closures.create');
    Route::post('/daily-closures', [DailyClosureController::class, 'store'])->name('daily-closures.store');
    Route::get('/daily-closures/{dailyClosure}', [DailyClosureController::class, 'show'])->name('daily-closures.show');
    
    Route::get('/reports/sales', [ReportController::class, 'index'])->name('reports.sales.index');

    Route::get('/export-products-stock', [ExportController::class, 'exportProductsStock'])->name('export.products_stock');


    Route::resource('transactions', TransactionController::class);
});

