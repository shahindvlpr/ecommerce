<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Address;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',

        'role',
        'is_admin',
        'vendor_status',

        'avatar',
        'phone',

        'address',
        'city',
        'state',
        'postal_code',
        'country',

        'status',

        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [

            'email_verified_at' => 'datetime',

            'last_login_at' => 'datetime',

            'password' => 'hashed',

            'is_admin' => 'boolean',

            'status' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    const ROLE_ADMIN = 'admin';
    const ROLE_VENDOR = 'vendor';
    const ROLE_CUSTOMER = 'customer';

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Role Checks
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->hasRole([
            'Super Admin',
            'Admin'
        ]);
    }

    public function isVendor(): bool
    {
        return $this->hasRole('Vendor');
    }

    public function isCustomer(): bool
    {
        return $this->hasRole('Customer');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {

            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?background=8b5cf6&color=fff&name='
            . urlencode($this->name);
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);

        $initials = '';

        foreach ($words as $word) {

            $initials .= strtoupper(
                substr($word, 0, 1)
            );
        }

        return substr($initials, 0, 2);
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Route
    |--------------------------------------------------------------------------
    */

    public function getDashboardRoute(): string
    {
        if ($this->hasRole('Super Admin')) {

            return route('admin.dashboard');
        }

        if ($this->hasRole('Admin')) {

            return route('admin.dashboard');
        }

        if ($this->hasRole('Vendor')) {

            return route('vendor.dashboard');
        }

        return route('customer.dashboard');
    }
}