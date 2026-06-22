<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_withdraws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            
            $table->decimal('amount', 10, 2);
            $table->decimal('fee', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2);
            
            $table->string('payment_method')->default('bank_transfer'); // bank_transfer, bkash, nagad
            $table->string('status')->default('pending'); // pending, processing, completed, failed, cancelled
            
            $table->text('account_details')->nullable();
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['vendor_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_withdraws');
    }
};