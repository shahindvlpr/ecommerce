<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('vendor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('images')->nullable();
            $table->json('attributes')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('trending')->default(false);
            $table->boolean('status')->default(true);
            $table->integer('views')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('reviews_count')->default(0);
            $table->json('meta_data')->nullable();
            $table->timestamps();

            $table->index(['category_id', 'status']);
            $table->index('slug');
            $table->index('price');
            $table->index('featured');
            $table->index('vendor_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};