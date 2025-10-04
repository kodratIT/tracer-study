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
        Schema::table('employment_histories', function (Blueprint $table) {
            // Add is_active field to track current employment status
            $table->boolean('is_active')->default(false)->after('employment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employment_histories', function (Blueprint $table) {
            // Remove is_active
            $table->dropColumn('is_active');
        });
    }
};
