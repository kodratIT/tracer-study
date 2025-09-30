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
        Schema::create('survey_options', function (Blueprint $table) {
            $table->id('option_id');
            $table->unsignedBigInteger('question_id');
            $table->string('option_text');
            $table->integer('weight')->default(0);
            $table->integer('display_order');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('question_id')->references('question_id')->on('survey_questions')->onDelete('cascade');
            $table->index('question_id');
            $table->index('display_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_options');
    }
};
