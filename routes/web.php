<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect After Login
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return redirect()->route('admin.dashboard');

})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

            /*
            |--------------------------------------------------------------------------
            | Category
            |--------------------------------------------------------------------------
            */

            Route::resource('categories', CategoryController::class);

            /*
            |--------------------------------------------------------------------------
            | Future Modules
            |--------------------------------------------------------------------------
            */

            // Route::resource('subcategories', SubCategoryController::class);
            // Route::resource('brands', BrandController::class);
            // Route::resource('products', ProductController::class);
            // Route::resource('orders', OrderController::class);
            // Route::resource('coupons', CouponController::class);
            // Route::resource('banners', BannerController::class);
            // Route::resource('reviews', ReviewController::class);

        });

    /*
    |--------------------------------------------------------------------------
    | Vendor Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('vendor')
        ->name('vendor.')
        ->group(function () {

            // Route::get('/dashboard',
            // [VendorDashboardController::class,'index'])
            // ->name('dashboard');

        });

    /*
    |--------------------------------------------------------------------------
    | Customer Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('customer')
        ->name('customer.')
        ->group(function () {

            // Cart
            // Wishlist
            // Checkout
            // Orders

        });

});

require __DIR__ . '/auth.php';