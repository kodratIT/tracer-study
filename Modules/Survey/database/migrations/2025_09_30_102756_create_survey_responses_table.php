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
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id('response_id');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('alumni_id');
            $table->timestamp('submitted_at')->nullable();
            $table->enum('completion_status', ['draft', 'partial', 'completed'])->default('draft');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('session_id')->references('session_id')->on('tracer_study_sessions')->onDelete('cascade');
            $table->foreign('alumni_id')->references('alumni_id')->on('alumni')->onDelete('cascade');
            
            // Composite index as requested
            $table->index(['alumni_id', 'session_id']);
            $table->index('session_id');
            $table->index('completion_status');
            $table->index('submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
