<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\NotificationController;  
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorProductController;
use Illuminate\Support\Facades\Route;

// ============================================================
// ADMIN ROUTES (Role: Admin)
// ============================================================
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
    // PROFILE
    // ============================================================
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
    });

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
    // PAYMENTS
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
    // USERS (Resource)
    // ============================================================
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/change-role', [UserController::class, 'changeRole'])->name('users.change-role');

    // ============================================================
    // CUSTOMERS
    // ============================================================
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [UserController::class, 'customers'])->name('index');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/orders', [UserController::class, 'customerOrders'])->name('orders');
    });

    // ============================================================
    // VENDORS (Admin Manage)
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
    Route::get('/coupons/export', [CouponController::class, 'export'])->name('coupons.export');
    Route::post('/coupons/apply', [CouponController::class, 'apply'])->name('coupons.apply');
    Route::post('/coupons/{coupon}/duplicate', [CouponController::class, 'duplicate'])->name('coupons.duplicate');

    // ============================================================
    // BANNERS
    // ============================================================
    Route::resource('banners', BannerController::class);
    Route::post('/banners/{banner}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggle-status');
    Route::post('/banners/{banner}/duplicate', [BannerController::class, 'duplicate'])->name('banners.duplicate');

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
        Route::post('/general', [SettingController::class, 'updateGeneral'])->name('update.general');
        Route::post('/payment', [SettingController::class, 'updatePayment'])->name('update.payment');
        Route::post('/shipping', [SettingController::class, 'updateShipping'])->name('update.shipping');
        Route::post('/email', [SettingController::class, 'updateEmail'])->name('update.email');
        Route::post('/seo', [SettingController::class, 'updateSeo'])->name('update.seo');
        Route::post('/social', [SettingController::class, 'updateSocial'])->name('update.social');
        Route::post('/clear-cache', [SettingController::class, 'clearCache'])->name('clear-cache');
        Route::post('/settings/test-email', [SettingController::class, 'testEmail'])->name('settings.test-email');
    });

    // ============================================================
    // NOTIFICATIONS
    // ============================================================
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/unread', [NotificationController::class, 'getUnreadCount'])->name('unread');
        Route::get('/latest', [NotificationController::class, 'getLatest'])->name('latest');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/destroy-all', [NotificationController::class, 'destroyAll'])->name('destroy-all');
    });

    // ============================================================
    // RETURNS
    // ============================================================
    Route::prefix('returns')->name('returns.')->group(function () {
        Route::get('/', [ReturnController::class, 'index'])->name('index');
        Route::get('/pending', [ReturnController::class, 'pending'])->name('pending');
        Route::get('/approved', [ReturnController::class, 'approved'])->name('approved');
        Route::get('/completed', [ReturnController::class, 'completed'])->name('completed');
        Route::get('/{id}', [ReturnController::class, 'show'])->name('show');
        Route::put('/{id}/status', [ReturnController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{id}', [ReturnController::class, 'destroy'])->name('destroy');
    });

    // ============================================================
    // INVOICES
    // ============================================================
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/unpaid', [InvoiceController::class, 'unpaid'])->name('unpaid');
        Route::get('/paid', [InvoiceController::class, 'paid'])->name('paid');
        Route::get('/overdue', [InvoiceController::class, 'overdue'])->name('overdue');
        Route::get('/create/{orderId?}', [InvoiceController::class, 'create'])->name('create');
        Route::post('/', [InvoiceController::class, 'store'])->name('store');
        Route::get('/{id}', [InvoiceController::class, 'show'])->name('show');
        Route::put('/{id}', [InvoiceController::class, 'update'])->name('update');
        Route::delete('/{id}', [InvoiceController::class, 'destroy'])->name('destroy');
        // ✅ ইতিমধ্যে OrderController-এ generateInvoice আছে, তাই এটি কমেন্ট করুন
        // Route::get('/generate/{orderId}', [InvoiceController::class, 'generateFromOrder'])->name('generate');
    });

    // ============================================================
    // BACKUP
    // ============================================================
    Route::prefix('backup')->name('backup.')->group(function () {
        Route::get('/', [SettingController::class, 'backup'])->name('index');
        Route::post('/create', [SettingController::class, 'createBackup'])->name('create');
        Route::get('/download/{file}', [SettingController::class, 'downloadBackup'])->name('download');
        Route::delete('/delete/{file}', [SettingController::class, 'deleteBackup'])->name('delete');
    });

// ============================================================
// ACTIVITY LOG
// ============================================================
Route::prefix('activity')->name('activity.')->group(function () {
    Route::get('/', [ActivityLogController::class, 'index'])->name('index');
    Route::get('/recent', [ActivityLogController::class, 'recent'])->name('recent');
    Route::get('/export', [ActivityLogController::class, 'export'])->name('export');
    Route::get('/show/{id}', [ActivityLogController::class, 'show'])->name('show'); 
    Route::post('/mark-all-read', [ActivityLogController::class, 'markAllAsRead'])->name('mark-all-read');
    Route::post('/{id}/mark-read', [ActivityLogController::class, 'markAsRead'])->name('mark-read'); 
    Route::delete('/clear', [ActivityLogController::class, 'clearAll'])->name('clear');
    Route::delete('/{id}', [ActivityLogController::class, 'destroy'])->name('destroy'); 
});

}); // ✅ END: admin group

// ============================================================
// VENDOR ROUTES (Role: Vendor) - আলাদা গ্রুপ
// ============================================================
Route::middleware(['auth', 'vendor.access'])
    ->prefix('vendor')
    ->name('vendor.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [VendorProductController::class, 'index'])->name('index');
        Route::get('/create', [VendorProductController::class, 'create'])->name('create');
        Route::post('/', [VendorProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [VendorProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [VendorProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [VendorProductController::class, 'destroy'])->name('destroy');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [VendorOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [VendorOrderController::class, 'show'])->name('show');
        Route::put('/{order}/status', [VendorOrderController::class, 'updateStatus'])->name('update-status');
    });

    // Profile
    Route::get('/profile', [VendorDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [VendorDashboardController::class, 'updateProfile'])->name('profile.update');

}); // ✅ END: vendor group