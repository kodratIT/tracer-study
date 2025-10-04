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
        //     // Remove old fields
        //     $table->dropColumn([
        //         'start_date',
        //         'end_date',
        //         'is_current',
        //         'salary_range',
        //         'city',
        //         'country'
        //     ]);
            
        //     // Add new fields for employed/entrepreneur
        //     $table->string('company_phone', 20)->nullable()->after('job_description');
            
        //     // Add new fields for studying
        //     $table->string('institution_name')->nullable()->after('company_phone');
        //     $table->string('study_level')->nullable()->after('institution_name');
        //     $table->string('major')->nullable()->after('study_level');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('employment_histories', function (Blueprint $table) {
        //     // Remove new fields
        //     $table->dropColumn([
        //         'company_phone',
        //         'institution_name',
        //         'study_level',
        //         'major'
        //     ]);
            
        //     // Restore old fields
        //     $table->date('start_date')->nullable();
        //     $table->date('end_date')->nullable();
        //     $table->boolean('is_current')->default(false);
        //     $table->string('salary_range', 50)->nullable();
        //     $table->string('city', 100)->nullable();
        //     $table->string('country', 100)->default('Indonesia');
        // });
    }
};
