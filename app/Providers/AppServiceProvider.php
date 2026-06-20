<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ============================================================
        // ✅ Navbar এর জন্য Global Variables Inject করুন
        // ============================================================
        View::composer('layouts.admin.navbar', function ($view) {
            try {
                if (Auth::check()) {
                    $latestNotifications = Notification::where('user_id', Auth::id())
                        ->latest()
                        ->take(5)
                        ->get();
                    
                    $unreadNotifications = Notification::where('user_id', Auth::id())
                        ->where('is_read', false)
                        ->count();
                    
                    $pendingOrders = Order::where('status', 'pending')->count();
                    $pendingReviews = Review::where('is_approved', false)->count();
                    $lowStock = Product::where('stock', '<', 5)->where('stock', '>', 0)->count();
                } else {
                    $latestNotifications = collect([]);
                    $unreadNotifications = 0;
                    $pendingOrders = 0;
                    $pendingReviews = 0;
                    $lowStock = 0;
                }
                
                $totalUnread = $pendingOrders + $pendingReviews + $lowStock + $unreadNotifications;
                
                $view->with(compact(
                    'latestNotifications',
                    'unreadNotifications',
                    'pendingOrders',
                    'pendingReviews',
                    'lowStock',
                    'totalUnread'
                ));
                
            } catch (\Exception $e) {
                // যদি কোনো error হয়, ডিফল্ট মান দিন
                $view->with([
                    'latestNotifications' => collect([]),
                    'unreadNotifications' => 0,
                    'pendingOrders' => 0,
                    'pendingReviews' => 0,
                    'lowStock' => 0,
                    'totalUnread' => 0,
                ]);
            }
        });

        // ============================================================
        // ✅ Sidebar এর জন্যও Inject করুন (যদি প্রয়োজন হয়)
        // ============================================================
        View::composer('layouts.admin.sidebar', function ($view) {
            try {
                if (Auth::check()) {
                    $unreadNotifications = Notification::where('user_id', Auth::id())
                        ->where('is_read', false)
                        ->count();
                } else {
                    $unreadNotifications = 0;
                }
                $view->with('unreadNotifications', $unreadNotifications);
            } catch (\Exception $e) {
                $view->with('unreadNotifications', 0);
            }
        });
    }
}