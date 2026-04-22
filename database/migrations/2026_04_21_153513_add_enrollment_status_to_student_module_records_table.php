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
        Schema::table('student_module_records', function (Blueprint $table) {
            $table->enum('enrollment_status', ['pending', 'enrolled', 'dropped'])->default('pending')->after('schedule');
            $table->string('section')->nullable()->after('enrollment_status');
            $table->index('enrollment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_module_records', function (Blueprint $table) {
            $table->dropIndex(['enrollment_status']);
            $table->dropColumn(['enrollment_status', 'section']);
        });
    }
};
