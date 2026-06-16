<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('attribute_name');
            $table->string('attribute_value');
            $table->string('sku')->unique()->nullable();
            $table->decimal('price_adjustment', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'attribute_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};