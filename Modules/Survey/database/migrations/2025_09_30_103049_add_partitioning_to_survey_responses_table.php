<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // DISABLED: MySQL partitioning has complex requirements:
        // 1. Primary key must include partition column (session_id)
        // 2. Foreign keys are not supported with partitioning
        // 
        // This would require changing the table structure significantly.
        // Partitioning is an optimization and not required for functionality.
        // Skip this migration for now.
        
        // If needed in production, consider using separate tables per year instead.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed since partitioning is disabled
    }
};
