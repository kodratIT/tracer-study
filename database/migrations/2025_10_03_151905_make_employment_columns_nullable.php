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
        // Schema::table('employment_histories', function (Blueprint $table) {
        //     // Make columns nullable for unemployed and studying status
        //     $table->string('job_title')->nullable()->change();
        //     $table->string('job_level')->nullable()->change();
        //     $table->string('contract_type')->nullable()->change();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('employment_histories', function (Blueprint $table) {
        //     // Revert back to NOT NULL (if needed)
        //     $table->string('job_title')->nullable(false)->change();
        //     $table->string('job_level')->nullable(false)->change();
        //     $table->string('contract_type')->nullable(false)->change();
        // });
    }
};
