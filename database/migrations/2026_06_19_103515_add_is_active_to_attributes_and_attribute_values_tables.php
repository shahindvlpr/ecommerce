<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Attributes Table
        Schema::table('attributes', function (Blueprint $table) {
            if (!Schema::hasColumn('attributes', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('type');
            }
            if (!Schema::hasColumn('attributes', 'slug')) {
                $table->string('slug')->unique()->nullable()->after('name');
            }
        });

        // Attribute Values Table
        Schema::table('attribute_values', function (Blueprint $table) {
            if (!Schema::hasColumn('attribute_values', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('sort_order');
            }
            if (!Schema::hasColumn('attribute_values', 'slug')) {
                $table->string('slug')->unique()->nullable()->after('value');
            }
            if (!Schema::hasColumn('attribute_values', 'label')) {
                $table->string('label')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('attribute_values', 'image')) {
                $table->string('image')->nullable()->after('color_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'slug']);
        });

        Schema::table('attribute_values', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'slug', 'label', 'image']);
        });
    }
};