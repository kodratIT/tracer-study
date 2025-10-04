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
            $table->enum('employment_status', ['employed', 'unemployed', 'studying', 'entrepreneur'])->default('employed')->after('contract_type');
            $table->text('job_description')->nullable()->after('employment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employment_histories', function (Blueprint $table) {
            $table->dropColumn([
                'employment_status',
                'job_description'
            ]);
        });
    }
};
