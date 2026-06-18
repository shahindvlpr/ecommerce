<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            if (!Schema::hasColumn('chat_messages', 'attachment')) {
                $table->string('attachment')->nullable()->after('message');
            }
            if (!Schema::hasColumn('chat_messages', 'attachment_type')) {
                $table->string('attachment_type')->nullable()->after('attachment');
            }
            if (!Schema::hasColumn('chat_messages', 'attachment_name')) {
                $table->string('attachment_name')->nullable()->after('attachment_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropColumn(['attachment', 'attachment_type', 'attachment_name']);
        });
    }
};