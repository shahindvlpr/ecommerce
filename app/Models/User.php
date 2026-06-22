<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Address;
use App\Models\VendorEarning;
use App\Models\VendorWithdraw;
use App\Models\VendorCommission;
use App\Models\ActivityLog;

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

        // ✅ Vendor Fields (যোগ করুন)
        'shop_name',
        'shop_slug',
        'shop_description',
        'shop_logo',
        'shop_banner',
        'shop_address',
        'shop_phone',
        'is_vendor_approved',
        'vendor_approved_at',
        'vendor_rejection_reason',
        'commission_rate',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
        'bank_routing_number',

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
            'is_vendor_approved' => 'boolean',
            'commission_rate' => 'decimal:2',
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

    // ✅ Vendor Relationships
    public function vendorEarnings(): HasMany
    {
        return $this->hasMany(VendorEarning::class, 'vendor_id');
    }

    public function vendorWithdraws(): HasMany
    {
        return $this->hasMany(VendorWithdraw::class, 'vendor_id');
    }

    public function vendorCommissions(): HasMany
    {
        return $this->hasMany(VendorCommission::class, 'vendor_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Role Checks
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->hasRole(['Super Admin', 'Admin']) || $this->role === 'admin' || $this->is_admin;
    }

    public function isVendor(): bool
    {
        return $this->hasRole('Vendor') || $this->role === 'vendor';
    }

    public function isCustomer(): bool
    {
        return $this->hasRole('Customer') || $this->role === 'customer';
    }

    // ✅ Vendor Approval Check
    public function isVendorApproved(): bool
    {
        return $this->is_vendor_approved && $this->role === 'vendor';
    }

    // ✅ Vendor Status Check
    public function isActiveVendor(): bool
    {
        return $this->isVendor() && $this->is_vendor_approved && $this->status;
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
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return substr($initials, 0, 2);
    }

    // ✅ Shop Logo URL
    public function getShopLogoUrlAttribute(): string
    {
        if ($this->shop_logo) {
            return asset('storage/' . $this->shop_logo);
        }

        return 'https://ui-avatars.com/api/?background=4f46e5&color=fff&name='
            . urlencode($this->shop_name ?? $this->name);
    }

    // ✅ Shop Banner URL
    public function getShopBannerUrlAttribute(): ?string
    {
        if ($this->shop_banner) {
            return asset('storage/' . $this->shop_banner);
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Route
    |--------------------------------------------------------------------------
    */

    public function getDashboardRoute(): string
    {
        if ($this->isAdmin()) {
            return route('admin.dashboard');
        }

        if ($this->isVendor()) {
            return route('vendor.dashboard');
        }

        return route('customer.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeVendors($query)
    {
        return $query->where('role', 'vendor');
    }

    public function scopeApprovedVendors($query)
    {
        return $query->where('role', 'vendor')->where('is_vendor_approved', true);
    }

    public function scopePendingVendors($query)
    {
        return $query->where('role', 'vendor')->where('is_vendor_approved', false);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}