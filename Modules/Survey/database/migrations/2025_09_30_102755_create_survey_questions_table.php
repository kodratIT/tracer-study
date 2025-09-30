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
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id('question_id');
            $table->unsignedBigInteger('session_id');
            $table->text('question_text');
            $table->enum('question_type', ['text', 'textarea', 'radio', 'checkbox', 'select', 'rating', 'date']);
            $table->integer('display_order');
            $table->boolean('is_required')->default(false);
            $table->json('validation_rules')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('session_id')->references('session_id')->on('tracer_study_sessions')->onDelete('cascade');
            $table->index('session_id');
            $table->index('display_order');
            $table->index('question_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
