<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;

// Admin Controllers
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
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;

// Vendor Controllers
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorOrderController;

// Customer Controllers
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerReviewController;
use App\Http\Controllers\Customer\AddressController;

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/category/{slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/shop/brand/{slug}', [ShopController::class, 'brand'])->name('shop.brand');

// Product Routes
Route::get('/product/{slug}', [FrontendProductController::class, 'show'])->name('product.show');
Route::get('/product/search', [FrontendProductController::class, 'search'])->name('product.search');

// Page Routes
Route::get('/about', function () {
    return view('frontend.pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('frontend.pages.contact');
})->name('contact');

Route::get('/faq', function () {
    return view('frontend.pages.faq');
})->name('faq');

Route::get('/terms', function () {
    return view('frontend.pages.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('frontend.pages.privacy');
})->name('privacy');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Login Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard Redirect
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role === 'admin' || $user->is_admin) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'vendor') {
            return redirect()->route('vendor.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile Management
    |--------------------------------------------------------------------------
    */

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Cart Routes (For All Authenticated Users)
    |--------------------------------------------------------------------------
    */

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
    Route::get('/total', [CartController::class, 'getCartTotal'])->name('total');
});

    /*
    |--------------------------------------------------------------------------
    | Wishlist Routes (For All Authenticated Users)
    |--------------------------------------------------------------------------
    */

    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/add/{productId}', [WishlistController::class, 'add'])->name('add');
        Route::delete('/remove/{id}', [WishlistController::class, 'remove'])->name('remove');
        Route::delete('/clear', [WishlistController::class, 'clear'])->name('clear');
        Route::get('/count', [WishlistController::class, 'getCount'])->name('count');
        Route::get('/check/{productId}', [WishlistController::class, 'check'])->name('check');
    });

    /*
    |--------------------------------------------------------------------------
    | Checkout Routes (For All Authenticated Users)
    |--------------------------------------------------------------------------
    */

Route::prefix('checkout')->name('checkout.')->middleware(['auth'])->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');  // GET
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');  // POST
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
    Route::get('/cancel', [CheckoutController::class, 'cancel'])->name('cancel');
});


    /*
    |--------------------------------------------------------------------------
    | Customer Routes (Role: Customer)
    |--------------------------------------------------------------------------
    */

    Route::prefix('customer')->name('customer.')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        
        // Orders
        Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('orders.cancel');
        Route::get('/orders/{order}/invoice', [CustomerOrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('/orders/stats', [CustomerOrderController::class, 'getStats'])->name('orders.stats');
        Route::get('/orders/statuses', [CustomerOrderController::class, 'getStatuses'])->name('orders.statuses');
        
        // Profile
        Route::get('/profile', [CustomerDashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [CustomerDashboardController::class, 'updateProfile'])->name('profile.update');
        
        // Wishlist (Customer Panel থেকে Access)
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
    Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist/count', [WishlistController::class, 'getCount'])->name('wishlist.count');
    Route::get('/wishlist/check/{productId}', [WishlistController::class, 'check'])->name('wishlist.check');
        
        // Reviews
        Route::get('/reviews', [CustomerReviewController::class, 'index'])->name('reviews');
        Route::post('/reviews', [CustomerReviewController::class, 'store'])->name('reviews.store');
        Route::put('/reviews/{review}', [CustomerReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [CustomerReviewController::class, 'destroy'])->name('reviews.destroy');
        
        // Addresses
        Route::get('/addresses', [AddressController::class, 'index'])->name('addresses');
        Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
        Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
        Route::get('/addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
        Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
        Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
        Route::post('/addresses/{address}/default', [AddressController::class, 'setDefault'])->name('addresses.default');
    });

    /*
    |--------------------------------------------------------------------------
    | Vendor Routes (Role: Vendor)
    |--------------------------------------------------------------------------
    */

    Route::prefix('vendor')->name('vendor.')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
        
        // Profile
        Route::get('/profile', [VendorDashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [VendorDashboardController::class, 'updateProfile'])->name('profile.update');
        
        // Product Management
        Route::resource('products', VendorProductController::class);
        Route::post('/products/{product}/toggle-status', [VendorProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::get('/products/export/excel', [VendorProductController::class, 'exportExcel'])->name('products.export.excel');
        
        // Order Management
        Route::get('/orders', [VendorOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [VendorOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [VendorOrderController::class, 'updateStatus'])->name('orders.update-status');
        
        // Reports
        Route::get('/sales-report', [VendorDashboardController::class, 'salesReport'])->name('sales-report');
        Route::get('/sales-report/export', [VendorDashboardController::class, 'exportReport'])->name('sales-report.export');
        
        // Earnings
        Route::get('/earnings', [VendorDashboardController::class, 'earnings'])->name('earnings');
        Route::get('/earnings/withdraw', [VendorDashboardController::class, 'withdraw'])->name('earnings.withdraw');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes (Role: Admin)
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->name('admin.')->group(function () {

        /*
        |----------------------------------------------------------------------
        | Dashboard & Analytics
        |----------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
        Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
        
        /*
        |----------------------------------------------------------------------
        | Category Management
        |----------------------------------------------------------------------
        */

        Route::resource('categories', CategoryController::class);
        Route::post('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::get('/categories/export/excel', [CategoryController::class, 'exportExcel'])->name('categories.export.excel');
        Route::get('/categories/export/pdf', [CategoryController::class, 'exportPdf'])->name('categories.export.pdf');
        
        /*
        |----------------------------------------------------------------------
        | Brand Management
        |----------------------------------------------------------------------
        */

        Route::resource('brands', BrandController::class);
        Route::post('/brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');
        
        /*
        |----------------------------------------------------------------------
        | Product Management
        |----------------------------------------------------------------------
        */

        Route::resource('products', ProductController::class);
        Route::post('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::post('/products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
        Route::get('/products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
        Route::get('/products/export/pdf', [ProductController::class, 'exportPdf'])->name('products.export.pdf');
        Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
        Route::get('/products/download-sample', [ProductController::class, 'downloadSample'])->name('products.download-sample');
        
        // Product Attributes
        Route::resource('attributes', AttributeController::class);
        Route::resource('attribute-values', AttributeValueController::class);
        
        /*
        |----------------------------------------------------------------------
        | Order Management
        |----------------------------------------------------------------------
        */

        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/pending', [OrderController::class, 'pending'])->name('pending');
            Route::get('/processing', [OrderController::class, 'processing'])->name('processing');
            Route::get('/completed', [OrderController::class, 'completed'])->name('completed');
            Route::get('/cancelled', [OrderController::class, 'cancelled'])->name('cancelled');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
            Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('update-status');
            Route::get('/{order}/invoice', [OrderController::class, 'generateInvoice'])->name('invoice');
            Route::post('/{order}/send-email', [OrderController::class, 'sendOrderEmail'])->name('send-email');
            Route::get('/export/excel', [OrderController::class, 'exportExcel'])->name('export.excel');
            Route::get('/export/pdf', [OrderController::class, 'exportPdf'])->name('export.pdf');
        });
        
        /*
        |----------------------------------------------------------------------
        | User Management
        |----------------------------------------------------------------------
        */

        Route::resource('users', UserController::class);
        Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::post('/users/{user}/change-role', [UserController::class, 'changeRole'])->name('users.change-role');
        Route::get('/users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
        
        // Customer Management
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', [UserController::class, 'customers'])->name('index');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/orders', [UserController::class, 'customerOrders'])->name('orders');
        });
        
        // Vendor Management
        Route::prefix('vendors')->name('vendors.')->group(function () {
            Route::get('/', [UserController::class, 'vendors'])->name('index');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::post('/{user}/approve', [UserController::class, 'approveVendor'])->name('approve');
            Route::get('/{user}/products', [UserController::class, 'vendorProducts'])->name('products');
        });
        
        /*
        |----------------------------------------------------------------------
        | Coupon Management
        |----------------------------------------------------------------------
        */

        Route::resource('coupons', CouponController::class);
        Route::post('/coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
        
        /*
        |----------------------------------------------------------------------
        | Banner Management
        |----------------------------------------------------------------------
        */

        Route::resource('banners', BannerController::class);
        Route::post('/banners/{banner}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggle-status');
        
        /*
        |----------------------------------------------------------------------
        | Review Management
        |----------------------------------------------------------------------
        */

        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [ReviewController::class, 'index'])->name('index');
            Route::get('/pending', [ReviewController::class, 'pending'])->name('pending');
            Route::post('/{review}/approve', [ReviewController::class, 'approve'])->name('approve');
            Route::post('/{review}/reject', [ReviewController::class, 'reject'])->name('reject');
            Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
        });
        
        /*
        |----------------------------------------------------------------------
        | Reports & Analytics
        |----------------------------------------------------------------------
        */

        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
            Route::get('/products', [ReportController::class, 'products'])->name('products');
            Route::get('/users', [ReportController::class, 'users'])->name('users');
            Route::get('/top-selling', [ReportController::class, 'topSelling'])->name('top-selling');
            Route::get('/low-stock', [ReportController::class, 'lowStock'])->name('low-stock');
            Route::get('/export/sales', [ReportController::class, 'exportSales'])->name('export.sales');
            Route::get('/export/products', [ReportController::class, 'exportProducts'])->name('export.products');
        });
        
        /*
        |----------------------------------------------------------------------
        | Settings & Configuration
        |----------------------------------------------------------------------
        */

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('/general', [SettingController::class, 'updateGeneral'])->name('general');
            Route::post('/payment', [SettingController::class, 'updatePayment'])->name('payment');
            Route::post('/shipping', [SettingController::class, 'updateShipping'])->name('shipping');
            Route::post('/email', [SettingController::class, 'updateEmail'])->name('email');
            Route::post('/seo', [SettingController::class, 'updateSeo'])->name('seo');
            Route::post('/social', [SettingController::class, 'updateSocial'])->name('social');
            Route::post('/clear-cache', [SettingController::class, 'clearCache'])->name('clear-cache');
        });
        
        /*
        |----------------------------------------------------------------------
        | Notifications
        |----------------------------------------------------------------------
        */

        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [DashboardController::class, 'notifications'])->name('index');
            Route::post('/{id}/read', [DashboardController::class, 'markAsRead'])->name('read');
            Route::post('/read-all', [DashboardController::class, 'markAllAsRead'])->name('read-all');
        });
        
        /*
        |----------------------------------------------------------------------
        | Backup & Maintenance
        |----------------------------------------------------------------------
        */

        Route::prefix('backup')->name('backup.')->group(function () {
            Route::get('/', [SettingController::class, 'backup'])->name('index');
            Route::post('/create', [SettingController::class, 'createBackup'])->name('create');
            Route::get('/download/{file}', [SettingController::class, 'downloadBackup'])->name('download');
            Route::delete('/delete/{file}', [SettingController::class, 'deleteBackup'])->name('delete');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Webhook Routes (No CSRF Protection)
|--------------------------------------------------------------------------
*/

Route::prefix('webhook')->name('webhook.')->group(function () {
    Route::post('/stripe', [App\Http\Controllers\Webhook\StripeWebhookController::class, 'handle'])->name('stripe');
    Route::post('/paypal', [App\Http\Controllers\Webhook\PaypalWebhookController::class, 'handle'])->name('paypal');
    Route::post('/sslcommerz', [App\Http\Controllers\Webhook\SslCommerzWebhookController::class, 'handle'])->name('sslcommerz');
});

/*
|--------------------------------------------------------------------------
| AJAX Routes (For API-like functionality)
|--------------------------------------------------------------------------
*/

Route::prefix('ajax')->name('ajax.')->middleware(['auth'])->group(function () {
    // Products
    Route::get('/products/search', [FrontendProductController::class, 'ajaxSearch'])->name('products.search');
    Route::get('/products/filter', [ShopController::class, 'ajaxFilter'])->name('products.filter');
    
    // Cart
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
    Route::get('/cart/total', [CartController::class, 'getCartTotal'])->name('cart.total');
    
    // Wishlist
    Route::get('/wishlist/count', [WishlistController::class, 'getCount'])->name('wishlist.count');
    Route::get('/wishlist/check/{productId}', [WishlistController::class, 'check'])->name('wishlist.check');
    
    // Locations
    Route::get('/divisions', [CheckoutController::class, 'getDivisions'])->name('divisions');
    Route::get('/districts/{divisionId}', [CheckoutController::class, 'getDistricts'])->name('districts');
    Route::get('/upazilas/{districtId}', [CheckoutController::class, 'getUpazilas'])->name('upazilas');
    
    // Checkout
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
});

/*
|--------------------------------------------------------------------------
| Sitemap & Robots
|--------------------------------------------------------------------------
*/

Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [HomeController::class, 'robots'])->name('robots');