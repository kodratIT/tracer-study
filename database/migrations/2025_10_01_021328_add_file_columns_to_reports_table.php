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
        // DISABLED: The complete reports table structure is defined in
        // Modules/Reports/database/migrations/2025_10_01_012728_create_reports_table.php
        // file_path and other columns already exist there
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed
    }
};
