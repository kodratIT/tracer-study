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
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->year('graduation_year');
            $table->string('major');
            $table->string('faculty');
            $table->decimal('gpa', 3, 2)->nullable();
            $table->string('current_job')->nullable();
            $table->string('current_company')->nullable();
            $table->decimal('current_salary', 12, 2)->nullable();
            $table->string('job_category')->nullable();
            $table->string('work_location')->nullable();
            $table->boolean('is_employed')->default(false);
            $table->enum('employment_status', ['employed', 'unemployed', 'entrepreneur', 'continuing_study'])->default('unemployed');
            $table->string('linkedin_profile')->nullable();
            $table->text('address')->nullable();
            $table->string('profile_photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['graduation_year', 'major']);
            $table->index(['is_employed', 'employment_status']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
