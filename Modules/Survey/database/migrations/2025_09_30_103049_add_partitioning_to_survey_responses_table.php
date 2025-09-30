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
        // Note: MySQL partitioning only works on MySQL, skip for other databases
        if (DB::getDriverName() === 'mysql') {
            DB::statement("
                ALTER TABLE survey_responses 
                PARTITION BY RANGE (session_id) (
                    PARTITION p_session_2024 VALUES LESS THAN (100),
                    PARTITION p_session_2025 VALUES LESS THAN (200),
                    PARTITION p_session_2026 VALUES LESS THAN (300),
                    PARTITION p_session_future VALUES LESS THAN MAXVALUE
                )
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE survey_responses REMOVE PARTITIONING");
        }
    }
};
