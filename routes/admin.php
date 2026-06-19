<?php

use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\PaymentController;  // ✅ সঠিক namespace
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin.access'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // ============================================================
    // DASHBOARD
    // ============================================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

    // ============================================================
    // CATEGORIES
    // ============================================================
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // ============================================================
    // BRANDS
    // ============================================================
    Route::resource('brands', BrandController::class);
    Route::post('/brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');

    // ============================================================
    // PRODUCTS
    // ============================================================
    Route::resource('products', ProductController::class);
    Route::post('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('/products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::get('/products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');

    // ============================================================
    // ATTRIBUTES
    // ============================================================
    Route::resource('attributes', AttributeController::class);
    Route::post('/attributes/{attribute}/toggle-status', [AttributeController::class, 'toggleStatus'])->name('attributes.toggle-status');

    // ============================================================
    // ATTRIBUTE VALUES
    // ============================================================
    Route::resource('attribute-values', AttributeValueController::class);

    // ============================================================
    // ORDERS
    // ============================================================
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

    // ============================================================
    // ✅ PAYMENTS (সঠিকভাবে)
    // ============================================================
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/pending', [PaymentController::class, 'pending'])->name('pending');
        Route::get('/paid', [PaymentController::class, 'paid'])->name('paid');
        Route::get('/failed', [PaymentController::class, 'failed'])->name('failed');
        Route::get('/refunded', [PaymentController::class, 'refunded'])->name('refunded');
        Route::get('/{payment}', [PaymentController::class, 'show'])->name('show');
        Route::post('/{payment}/status', [PaymentController::class, 'updateStatus'])->name('update-status');
        Route::get('/export/excel', [PaymentController::class, 'exportExcel'])->name('export.excel');
    });

    // ============================================================
    // USERS
    // ============================================================
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/change-role', [UserController::class, 'changeRole'])->name('users.change-role');

    // ============================================================
    // VENDORS
    // ============================================================
    Route::prefix('vendors')->name('vendors.')->group(function () {
        Route::get('/', [UserController::class, 'vendors'])->name('index');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::post('/{user}/approve', [UserController::class, 'approveVendor'])->name('approve');
        Route::get('/{user}/products', [UserController::class, 'vendorProducts'])->name('products');
    });

    // ============================================================
    // COUPONS
    // ============================================================
    Route::resource('coupons', CouponController::class);
    Route::post('/coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');

    // ============================================================
    // BANNERS
    // ============================================================
    Route::resource('banners', BannerController::class);
    Route::post('/banners/{banner}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggle-status');

    // ============================================================
    // REVIEWS
    // ============================================================
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/pending', [ReviewController::class, 'pending'])->name('pending');
        Route::post('/{review}/approve', [ReviewController::class, 'approve'])->name('approve');
        Route::post('/{review}/reject', [ReviewController::class, 'reject'])->name('reject');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
    });

    // ============================================================
    // REPORTS
    // ============================================================
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/products', [ReportController::class, 'products'])->name('products');
        Route::get('/users', [ReportController::class, 'users'])->name('users');
        Route::get('/top-selling', [ReportController::class, 'topSelling'])->name('top-selling');
        Route::get('/low-stock', [ReportController::class, 'lowStock'])->name('low-stock');
        Route::get('/export/sales', [ReportController::class, 'exportSales'])->name('export.sales');
    });

    // ============================================================
    // SETTINGS
    // ============================================================

// Settings
Route::prefix('settings')->name('settings.')->group(function () {
    // GET routes
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::get('/general', [SettingController::class, 'general'])->name('general');
    Route::get('/payment', [SettingController::class, 'payment'])->name('payment');
    Route::get('/shipping', [SettingController::class, 'shipping'])->name('shipping');
    Route::get('/email', [SettingController::class, 'email'])->name('email');
    Route::get('/seo', [SettingController::class, 'seo'])->name('seo');
    Route::get('/social', [SettingController::class, 'social'])->name('social');
    
    // POST routes
    Route::post('/general', [SettingController::class, 'updateGeneral'])->name('general');
    Route::post('/payment', [SettingController::class, 'updatePayment'])->name('payment');
    Route::post('/shipping', [SettingController::class, 'updateShipping'])->name('shipping');
    Route::post('/email', [SettingController::class, 'updateEmail'])->name('email');
    Route::post('/seo', [SettingController::class, 'updateSeo'])->name('seo');
    Route::post('/social', [SettingController::class, 'updateSocial'])->name('social');
    Route::post('/clear-cache', [SettingController::class, 'clearCache'])->name('clear-cache');
});

    // ============================================================
    // NOTIFICATIONS
    // ============================================================
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [DashboardController::class, 'notifications'])->name('index');
        Route::post('/{id}/read', [DashboardController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [DashboardController::class, 'markAllAsRead'])->name('read-all');
    });


// Users
Route::resource('users', UserController::class);
Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
Route::post('/users/{user}/change-role', [UserController::class, 'changeRole'])->name('users.change-role');

// Customers (জন্য আলাদা Route)
Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('/', [UserController::class, 'customers'])->name('index');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::get('/{user}/orders', [UserController::class, 'customerOrders'])->name('orders');
});

// Vendors (জন্য আলাদা Route)
Route::prefix('vendors')->name('vendors.')->group(function () {
    Route::get('/', [UserController::class, 'vendors'])->name('index');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::post('/{user}/approve', [UserController::class, 'approveVendor'])->name('approve');
    Route::get('/{user}/products', [UserController::class, 'vendorProducts'])->name('products');
});












});