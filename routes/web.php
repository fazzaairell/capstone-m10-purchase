<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/suppliers');

// CRUD supplier: index, create, store, show, edit, update, destroy
Route::resource('suppliers', SupplierController::class);

// Placeholder untuk menu sidebar yang modulnya belum dibuat.
// Ganti dengan Route::resource(...) kalau modulnya sudah ada.
Route::view('/permintaan-pembelian', 'segera', ['judul' => 'Permintaan pembelian'])
    ->name('purchase-requests.index');

Route::view('/purchase-order', 'segera', ['judul' => 'Purchase order'])
    ->name('purchase-orders.index');