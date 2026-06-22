<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            
            $table->decimal('amount', 10, 2);
            $table->decimal('commission', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2);
            
            $table->string('type')->default('sale'); // sale, refund, bonus
            $table->string('status')->default('pending'); // pending, paid, cancelled
            
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            
            $table->index(['vendor_id', 'status']);
            $table->index(['order_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_earnings');
    }
};