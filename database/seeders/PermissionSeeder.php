<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            'dashboard.view',

            'category.view',
            'category.create',
            'category.edit',
            'category.delete',

            'subcategory.view',
            'subcategory.create',
            'subcategory.edit',
            'subcategory.delete',

            'brand.view',
            'brand.create',
            'brand.edit',
            'brand.delete',

            'product.view',
            'product.create',
            'product.edit',
            'product.delete',

            'order.view',
            'order.manage',

            'vendor.view',
            'vendor.approve',

            'customer.view',

            'coupon.view',
            'coupon.create',
            'coupon.edit',
            'coupon.delete',

            'banner.view',
            'banner.create',
            'banner.edit',
            'banner.delete',
        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }
    }
}