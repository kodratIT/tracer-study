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
            $table->string('city')->nullable()->after('job_description');
            $table->string('country')->default('Indonesia')->after('city');
            $table->boolean('is_current')->default(false)->after('country');
            $table->timestamp('last_updated_at')->nullable()->after('is_current');
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
                'job_description',
                'city',
                'country',
                'is_current',
                'last_updated_at'
            ]);
        });
    }
};
