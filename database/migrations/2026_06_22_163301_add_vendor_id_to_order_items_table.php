<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Check if vendor_id column exists
            if (!Schema::hasColumn('order_items', 'vendor_id')) {
                $table->foreignId('vendor_id')->nullable()->after('product_id')->constrained('users')->onDelete('set null');
            }
            
            // Check if vendor_earnings column exists
            if (!Schema::hasColumn('order_items', 'vendor_earnings')) {
                $table->decimal('vendor_earnings', 10, 2)->default(0)->after('total');
            }
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'vendor_id')) {
                $table->dropForeign(['vendor_id']);
                $table->dropColumn('vendor_id');
            }
            if (Schema::hasColumn('order_items', 'vendor_earnings')) {
                $table->dropColumn('vendor_earnings');
            }
        });
    }
};