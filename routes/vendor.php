<?php

use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorProfileController;
use App\Http\Controllers\Vendor\VendorEarningController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'vendor.access'])
    ->prefix('vendor')
    ->name('vendor.')
    ->group(function () {

    // ============================================================
    // DASHBOARD
    // ============================================================
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/stats', [VendorDashboardController::class, 'stats'])->name('stats');

    // ============================================================
    // PROFILE
    // ============================================================
    Route::get('/profile', [VendorProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [VendorProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [VendorProfileController::class, 'updatePassword'])->name('profile.password');

    // ============================================================
    // PRODUCTS
    // ============================================================
    Route::resource('products', VendorProductController::class);
    Route::post('/products/{id}/toggle-status', [VendorProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::get('/products/export/excel', [VendorProductController::class, 'exportExcel'])->name('products.export');

    // ============================================================
    // ORDERS
    // ============================================================
    Route::get('/orders', [VendorOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [VendorOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [VendorOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/orders/{id}/invoice', [VendorOrderController::class, 'invoice'])->name('orders.invoice');

    // ============================================================
    // EARNINGS
    // ============================================================
    Route::get('/earnings', [VendorEarningController::class, 'index'])->name('earnings');
    Route::post('/earnings/withdraw', [VendorEarningController::class, 'withdraw'])->name('earnings.withdraw');
    Route::post('/earnings/request-withdraw', [VendorEarningController::class, 'requestWithdraw'])->name('earnings.request-withdraw');

    // ============================================================
    // REPORTS
    // ============================================================
    Route::get('/reports/sales', [VendorDashboardController::class, 'salesReport'])->name('reports.sales');
    Route::get('/reports/export', [VendorDashboardController::class, 'exportReport'])->name('reports.export');
});