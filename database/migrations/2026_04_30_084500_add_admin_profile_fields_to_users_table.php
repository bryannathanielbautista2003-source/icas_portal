<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Admin Profile module – additional profile columns for admin users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('title', 20)->nullable()->after('name');           // Dr., Mr., Ms., etc.
            $table->string('designation', 100)->nullable()->after('title');     // Director, Registrar, etc.
            $table->string('department', 100)->nullable()->after('designation');
            $table->string('office_hours', 100)->nullable()->after('department');
            $table->enum('gender', ['Male', 'Female', 'Other', 'Prefer not to say'])->nullable()->after('office_hours');
            $table->text('address')->nullable()->after('gender');
            $table->string('profile_photo')->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'designation',
                'department',
                'office_hours',
                'gender',
                'address',
                'profile_photo',
            ]);
        });
    }
};
