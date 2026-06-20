<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            $notifications = [
                [
                    'type' => 'order',
                    'title' => 'New Order #1234',
                    'message' => 'A new order has been placed by John Doe.',
                    'link' => '/admin/orders/1',
                    'color' => '#667eea',
                ],
                [
                    'type' => 'review',
                    'title' => 'New Review',
                    'message' => 'Sarah left a 5-star review on iPhone 15 Pro.',
                    'link' => '/admin/reviews/1',
                    'color' => '#f59e0b',
                ],
                [
                    'type' => 'product',
                    'title' => 'Low Stock Alert',
                    'message' => 'iPhone 15 Pro is running low on stock (5 left).',
                    'link' => '/admin/products/1',
                    'color' => '#ef4444',
                ],
                [
                    'type' => 'vendor',
                    'title' => 'New Vendor Registered',
                    'message' => 'TechStore has registered as a vendor.',
                    'link' => '/admin/vendors/1',
                    'color' => '#ec4899',
                ],
            ];

            foreach ($notifications as $notif) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type' => $notif['type'],
                    'title' => $notif['title'],
                    'message' => $notif['message'],
                    'link' => $notif['link'],
                    'color' => $notif['color'],
                    'is_read' => false,
                ]);
            }
        }
    }
}