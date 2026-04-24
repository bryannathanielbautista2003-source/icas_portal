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
            $table->boolean('grade_verified')->default(false)->after('grade_percent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_module_records', function (Blueprint $table) {
            $table->dropColumn('grade_verified');
        });
    }
};
