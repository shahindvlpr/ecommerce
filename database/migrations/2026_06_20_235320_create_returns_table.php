<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('return_number')->unique();
            $table->enum('reason', ['defective', 'wrong_item', 'size_issue', 'damaged', 'not_satisfied', 'other'])->default('other');
            $table->text('reason_details')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'processing', 'completed'])->default('pending');
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};