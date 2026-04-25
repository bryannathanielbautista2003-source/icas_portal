<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
        });

        Schema::table('forum_threads', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('content');
            $table->string('category')->default('General');
            $table->string('status')->default('open');
            $table->integer('views')->default(0);
        });

        Schema::table('system_settings', function (Blueprint $table) {
            $table->string('setting_key')->unique();
            $table->text('setting_value')->nullable();
            $table->string('type')->default('string');
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'action', 'description', 'ip_address']);
        });

        Schema::table('forum_threads', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'title', 'content', 'category', 'status', 'views']);
        });

        Schema::table('system_settings', function (Blueprint $table) {
            $table->dropColumn(['setting_key', 'setting_value', 'type', 'description']);
        });
    }
};
