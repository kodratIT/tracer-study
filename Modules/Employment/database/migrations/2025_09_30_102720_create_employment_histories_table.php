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
        Schema::create('employment_histories', function (Blueprint $table) {
            $table->id('employment_id');
            $table->unsignedBigInteger('alumni_id');
            $table->unsignedBigInteger('employer_id')->nullable();
            $table->string('job_title');
            $table->enum('job_level', ['entry', 'junior', 'senior', 'lead', 'manager', 'director', 'executive']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('salary_range')->nullable();
            $table->enum('contract_type', ['full_time', 'part_time', 'contract', 'freelance', 'internship']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('alumni_id')->references('alumni_id')->on('alumni')->onDelete('cascade');
            $table->foreign('employer_id')->references('employer_id')->on('employers')->onDelete('set null');
            $table->index('alumni_id');
            $table->index('employer_id');
            $table->index(['start_date', 'end_date']);
            $table->index('job_level');
            $table->index('contract_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_histories');
    }
};
