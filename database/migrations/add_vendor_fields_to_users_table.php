<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Vendor Shop Information
            $table->string('shop_name')->nullable()->after('role');
            $table->string('shop_slug')->nullable()->after('shop_name');
            $table->text('shop_description')->nullable()->after('shop_slug');
            $table->string('shop_logo')->nullable()->after('shop_description');
            $table->string('shop_banner')->nullable()->after('shop_logo');
            $table->string('shop_address')->nullable()->after('shop_banner');
            $table->string('shop_phone')->nullable()->after('shop_address');
            
            // Vendor Approval
            $table->boolean('is_vendor_approved')->default(false)->after('shop_phone');
            $table->timestamp('vendor_approved_at')->nullable()->after('is_vendor_approved');
            $table->text('vendor_rejection_reason')->nullable()->after('vendor_approved_at');
            
            // Commission & Payment
            $table->decimal('commission_rate', 5, 2)->default(10.00)->after('vendor_rejection_reason');
            $table->string('bank_name')->nullable()->after('commission_rate');
            $table->string('bank_account_number')->nullable()->after('bank_name');
            $table->string('bank_account_holder')->nullable()->after('bank_account_number');
            $table->string('bank_routing_number')->nullable()->after('bank_account_holder');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'shop_name', 'shop_slug', 'shop_description', 'shop_logo', 
                'shop_banner', 'shop_address', 'shop_phone',
                'is_vendor_approved', 'vendor_approved_at', 'vendor_rejection_reason',
                'commission_rate', 'bank_name', 'bank_account_number', 
                'bank_account_holder', 'bank_routing_number'
            ]);
        });
    }
};