<?php

namespace Database\Factories;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityLogFactory extends Factory
{
    protected $model = ActivityLog::class;

    public function definition(): array
    {
        $actions = ['login', 'logout', 'create', 'update', 'delete', 'view', 'status', 'export', 'import'];
        $modules = ['products', 'categories', 'orders', 'users', 'settings', 'reports', 'payments', 'shipping'];
        
        return [
            'user_id' => User::factory(),
            'action' => $this->faker->randomElement($actions),
            'module' => $this->faker->randomElement($modules),
            'ip_address' => $this->faker->ipv4,
            'description' => $this->faker->sentence(6),
            'data' => $this->faker->optional()->randomElement([
                ['id' => $this->faker->numberBetween(1, 100)],
                ['name' => $this->faker->word],
                ['status' => $this->faker->boolean],
                null
            ]),
            'is_read' => $this->faker->boolean(30),
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }

    /**
     * Indicate that the activity is a login action.
     */
    public function login(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'action' => 'login',
                'description' => 'User logged in successfully',
            ];
        });
    }

    /**
     * Indicate that the activity is a logout action.
     */
    public function logout(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'action' => 'logout',
                'description' => 'User logged out',
            ];
        });
    }

    /**
     * Indicate that the activity is a create action.
     */
    public function create(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'action' => 'create',
                'description' => 'Created a new ' . $this->faker->word,
            ];
        });
    }
}