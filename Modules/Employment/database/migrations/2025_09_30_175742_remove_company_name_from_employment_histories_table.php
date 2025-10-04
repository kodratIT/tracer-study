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
        // Disabled - Keep company_name column
        // Schema::table('employment_histories', function (Blueprint $table) {
        //     $table->dropColumn('company_name');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Disabled
        // Schema::table('employment_histories', function (Blueprint $table) {
        //     $table->string('company_name')->nullable()->after('employer_id');
        // });
    }
};
