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
        Schema::create('answers', function (Blueprint $table) {
            $table->id('answer_id');
            $table->unsignedBigInteger('response_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('option_id')->nullable();
            $table->text('answer_text')->nullable();
            $table->integer('rating_value')->nullable();
            $table->json('additional_data')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('response_id')->references('response_id')->on('survey_responses')->onDelete('cascade');
            $table->foreign('question_id')->references('question_id')->on('survey_questions')->onDelete('cascade');
            $table->foreign('option_id')->references('option_id')->on('survey_options')->onDelete('set null');
            
            $table->index('response_id');
            $table->index('question_id');
            $table->index('option_id');
            $table->index(['response_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
