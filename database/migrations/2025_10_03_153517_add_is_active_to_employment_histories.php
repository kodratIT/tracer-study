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
            
            // Remove last_updated_at as we don't need 6 months lock anymore
            $table->dropColumn('last_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employment_histories', function (Blueprint $table) {
            // Restore last_updated_at
            $table->timestamp('last_updated_at')->nullable();
            
            // Remove is_active
            $table->dropColumn('is_active');
        });
    }
};
