<?php

use App\Http\Controllers\{ProductController,StockController,SaleController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','prevent-back-history'])->group(function () {

    Route::resource('products', ProductController::class);

    Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::post('stocks', [StockController::class, 'store'])->name('stocks.store');
    Route::put('stocks/{id}', [StockController::class, 'update'])->name('stocks.update');
    
    Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('sales/store', [SaleController::class, 'store'])->name('sales.store');

});

require __DIR__.'/auth.php';
