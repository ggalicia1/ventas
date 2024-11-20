<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;


require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para Categorías
Route::resource('categories', CategoryController::class);

// Rutas para Productos
Route::resource('products', ProductController::class);

// Si quieres añadir una ruta para buscar productos:
Route::get('/products/search/{search}', [ProductController::class, 'search'])->name('products.search');

Route::get('/products/barcode/{barcode}', [ProductController::class, 'findByBarcode']);
Route::get('products/{id}/add-stock', [ProductController::class, 'showAddStockForm'])->name('products.addStock');
Route::post('products/{id}/add-stock', [ProductController::class, 'addProductStock'])->name('products.addStock.post');



Route::resource('sales', SaleController::class);
Route::get('sales/{id}/receipt', [SaleController::class, 'generateReceipt'])->name('sales.receipt');

Route::get('/reports/sales', [ReportController::class, 'index'])->name('reports.sales.index');
