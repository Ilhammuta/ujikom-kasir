<?php

use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Exports\PenjualanExport;
use App\Models\Penjualan;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/admin', [PenjualanController::class, 'dashboardAdmin'])->name('dashboard.admin');
    Route::get('/dashboard/employee', [PenjualanController::class, 'dashboard'])->name('dashboard.petugas');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('produk', ProdukController::class);
    Route::patch('/produk/{id}/stok', [ProdukController::class, 'updateStok'])->name('produk.updateStok');
    Route::resource('user', UserController::class);
    Route::resource('penjualan', PenjualanController::class);
    Route::get('/sales', [PenjualanController::class, 'sales'])->name('sales.index');
    Route::post('/sales/process-product', [PenjualanController::class, 'processProduct'])->name('sales.process.product');
    Route::post('/sales/process-member', [PenjualanController::class, 'processMember'])->name('sales.process.member');
    Route::post('/sales/member', [PenjualanController::class, 'member'])->name('sales.member');
    Route::post('/sales/store', [PenjualanController::class, 'store'])->name('sales.store');
    Route::get('invoice/{id}/download', [PenjualanController::class, 'downloadInvoice'])->name('penjualan.pdf');
    Route::get('/export-penjualan', function () {
        return Excel::download(new PenjualanExport, 'penjualan.xlsx');
    });
    Route::get('/chart-data', [PenjualanController::class, 'chartData']);
});



require __DIR__ . '/auth.php';
