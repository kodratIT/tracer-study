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
        Schema::create('reports', function (Blueprint $table) {
            $table->id('report_id');
            $table->string('title');
            $table->enum('report_type', [
                'employment_statistics',
                'waiting_period', 
                'job_relevance',
                'salary_analysis',
                'geographic_distribution',
                'satisfaction_survey',
                'response_rate',
                'alumni_tracking',
                'competency_analysis',
                'ban_pt_standard'
            ])->index();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->json('parameters')->nullable(); // Store filter parameters and options
            $table->enum('status', ['pending', 'generating', 'completed', 'failed', 'expired'])
                  ->default('pending')->index();
            $table->string('file_path')->nullable(); // Path to generated report file
            $table->enum('file_format', ['pdf', 'excel', 'csv'])->default('pdf');
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('expires_at')->nullable(); // Auto-cleanup old reports
            $table->json('metadata')->nullable(); // Store additional report info, stats, etc.
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('session_id')
                  ->references('session_id')
                  ->on('tracer_study_sessions')
                  ->onDelete('cascade');

            // Indexes for better performance
            $table->index(['status', 'created_at']);
            $table->index(['report_type', 'session_id']);
            $table->index(['expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
