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
        Schema::table('users', function (Blueprint $table) {
            // Track account source: csv_import, manual_registration, admin_created
            $table->enum('account_source', ['csv_import', 'manual_registration', 'admin_created'])
                ->default('manual_registration')
                ->after('status');

            // Force user to change password on first login (for CSV imports with default password)
            $table->boolean('force_password_change')
                ->default(false)
                ->after('account_source');

            // Timestamp when account was imported (null for manual/admin-created)
            $table->timestamp('imported_at')
                ->nullable()
                ->after('force_password_change');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('account_source');
            $table->dropColumn('force_password_change');
            $table->dropColumn('imported_at');
        });
    }
};
