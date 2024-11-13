<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', function () {
    return view('home');
})->name('home');


// Rutas para Categorías
Route::resource('categories', CategoryController::class);

// Rutas para Productos
Route::resource('products', ProductController::class);
//Route::get('products/search', [ProductController::class, 'search'])->name('products.search');


// Si quieres añadir una ruta para buscar productos:
Route::get('/products/search/{search}', [ProductController::class, 'search'])->name('products.search');

Route::get('/products/barcode/{barcode}', [ProductController::class, 'findByBarcode']);
Route::get('products/{id}/add-stock', [ProductController::class, 'showAddStockForm'])->name('products.addStock');
Route::post('products/{id}/add-stock', [ProductController::class, 'addProductStock'])->name('products.addStock.post');



Route::resource('sales', SaleController::class);
Route::get('sales/{id}/receipt', [SaleController::class, 'generateReceipt'])->name('sales.receipt');

Route::get('/reports/sales', [ReportController::class, 'index'])->name('reports.sales.index');


// Si necesitas rutas adicionales para reportes o dashboard:
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');