<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            
            // ✅ Customer Information (যোগ করা কলাম)
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('payment_method')->nullable();
            
            // Financials
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            
            // Statuses
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('pending');
            $table->string('shipping_status')->default('pending');
            
            // Addresses
            $table->text('shipping_address');
            $table->text('billing_address')->nullable();
            
            // Contact
            $table->string('phone');
            $table->string('email');
            
            // Additional
            $table->string('tracking_number')->nullable();
            $table->text('notes')->nullable();
            $table->json('meta_data')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->index('order_number');
            $table->index('status');
            $table->index('user_id');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};