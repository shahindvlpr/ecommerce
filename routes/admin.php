<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;

Route::middleware(['auth', 'admin.access'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

    // Categories
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // Brands
    Route::resource('brands', BrandController::class);
    Route::post('/brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');

    // Products
    Route::resource('products', ProductController::class);
    Route::post('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('/products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::get('/products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/pending', [OrderController::class, 'pending'])->name('pending');
        Route::get('/processing', [OrderController::class, 'processing'])->name('processing');
        Route::get('/completed', [OrderController::class, 'completed'])->name('completed');
        Route::get('/cancelled', [OrderController::class, 'cancelled'])->name('cancelled');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('update-status');
        Route::get('/{order}/invoice', [OrderController::class, 'generateInvoice'])->name('invoice');
        Route::get('/export/excel', [OrderController::class, 'exportExcel'])->name('export.excel');
    });

    // Users
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/change-role', [UserController::class, 'changeRole'])->name('users.change-role');

    // Vendors
    Route::prefix('vendors')->name('vendors.')->group(function () {
        Route::get('/', [UserController::class, 'vendors'])->name('index');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::post('/{user}/approve', [UserController::class, 'approveVendor'])->name('approve');
        Route::get('/{user}/products', [UserController::class, 'vendorProducts'])->name('products');
    });

    // Coupons
    Route::resource('coupons', CouponController::class);
    Route::post('/coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');

    // Banners
    Route::resource('banners', BannerController::class);
    Route::post('/banners/{banner}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggle-status');

    // Reviews
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/pending', [ReviewController::class, 'pending'])->name('pending');
        Route::post('/{review}/approve', [ReviewController::class, 'approve'])->name('approve');
        Route::post('/{review}/reject', [ReviewController::class, 'reject'])->name('reject');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/products', [ReportController::class, 'products'])->name('products');
        Route::get('/users', [ReportController::class, 'users'])->name('users');
        Route::get('/top-selling', [ReportController::class, 'topSelling'])->name('top-selling');
        Route::get('/low-stock', [ReportController::class, 'lowStock'])->name('low-stock');
        Route::get('/export/sales', [ReportController::class, 'exportSales'])->name('export.sales');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/general', [SettingController::class, 'updateGeneral'])->name('general');
        Route::post('/payment', [SettingController::class, 'updatePayment'])->name('payment');
        Route::post('/shipping', [SettingController::class, 'updateShipping'])->name('shipping');
        Route::post('/email', [SettingController::class, 'updateEmail'])->name('email');
        Route::post('/seo', [SettingController::class, 'updateSeo'])->name('seo');
        Route::post('/clear-cache', [SettingController::class, 'clearCache'])->name('clear-cache');
    });

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [DashboardController::class, 'notifications'])->name('index');
        Route::post('/{id}/read', [DashboardController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [DashboardController::class, 'markAllAsRead'])->name('read-all');
    });
});