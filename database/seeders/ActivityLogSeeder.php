<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        // Get admin users
        $users = User::where('role', 'admin')->get();

        if ($users->isEmpty()) {
            $users = User::all();
        }

        // Create 50 random activities
        foreach ($users as $user) {
            ActivityLog::factory()
                ->count($this->faker->numberBetween(5, 15))
                ->create(['user_id' => $user->id]);
        }

        // Create specific activities
        foreach ($users as $user) {
            // Login activities
            ActivityLog::factory()
                ->login()
                ->count(3)
                ->create(['user_id' => $user->id]);

            // Logout activities
            ActivityLog::factory()
                ->logout()
                ->count(2)
                ->create(['user_id' => $user->id]);

            // Create activities
            ActivityLog::factory()
                ->create()
                ->count(4)
                ->create(['user_id' => $user->id]);

            // Unread activities
            ActivityLog::factory()
                ->count(5)
                ->create([
                    'user_id' => $user->id,
                    'is_read' => false
                ]);
        }

        // Create recent activities (last 7 days)
        foreach ($users as $user) {
            ActivityLog::factory()
                ->count(10)
                ->create([
                    'user_id' => $user->id,
                    'created_at' => now()->subDays(rand(0, 7))
                ]);
        }

        $this->command->info('Activity logs seeded successfully!');
    }
}