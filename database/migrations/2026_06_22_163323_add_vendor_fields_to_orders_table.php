<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Check if vendor_id column exists
            if (!Schema::hasColumn('orders', 'vendor_id')) {
                $table->foreignId('vendor_id')->nullable()->after('user_id')->constrained('users')->onDelete('set null');
            }
            
            // Check if vendor_commission column exists
            if (!Schema::hasColumn('orders', 'vendor_commission')) {
                $table->decimal('vendor_commission', 10, 2)->default(0)->after('total');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'vendor_id')) {
                $table->dropForeign(['vendor_id']);
                $table->dropColumn('vendor_id');
            }
            if (Schema::hasColumn('orders', 'vendor_commission')) {
                $table->dropColumn('vendor_commission');
            }
        });
    }
};