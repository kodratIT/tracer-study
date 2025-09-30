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
        // Update job_level enum to include all the levels we use in the form
        DB::statement("ALTER TABLE employment_histories MODIFY job_level ENUM('entry', 'junior', 'mid', 'senior', 'lead', 'supervisor', 'manager', 'director', 'vp', 'ceo')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original enum values
        DB::statement("ALTER TABLE employment_histories MODIFY job_level ENUM('entry', 'junior', 'senior', 'lead', 'manager', 'director', 'executive')");
    }
};
