<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/suppliers');

// CRUD supplier: index, create, store, show, edit, update, destroy
Route::resource('suppliers', SupplierController::class);

// Placeholder untuk menu sidebar yang modulnya belum dibuat.
// Ganti dengan Route::resource(...) kalau modulnya sudah ada.
use App\Http\Controllers\PurchaseRequestController;

// menu sidebar "Permintaan pembelian" sementara diarahkan ke form,
// ganti dengan halaman daftar kalau sudah dibuat
Route::get('permintaan-pembelian', [PurchaseRequestController::class, 'index'])->name('purchase-requests.index');
Route::get('permintaan-pembelian/baru', [PurchaseRequestController::class, 'create'])->name('purchase-requests.create');
Route::post('permintaan-pembelian', [PurchaseRequestController::class, 'store'])->name('purchase-requests.store');

Route::view('/purchase-order', 'segera', ['judul' => 'Purchase order'])
    ->name('purchase-orders.index');