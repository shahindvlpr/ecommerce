<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('image');
            $table->string('mobile_image')->nullable();
            $table->string('url')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->string('position')->default('home');
            $table->integer('order')->default(0);
            $table->string('type')->default('image');
            $table->boolean('status')->default(true);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('meta_data')->nullable();
            $table->timestamps();

            $table->index('position');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};