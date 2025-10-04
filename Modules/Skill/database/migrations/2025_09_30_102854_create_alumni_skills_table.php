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
        Schema::create('alumni_skills', function (Blueprint $table) {
            $table->id('alumni_skill_id');
            $table->unsignedBigInteger('alumni_id');
            $table->unsignedBigInteger('skill_id');
            $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'expert']);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('alumni_id')->references('alumni_id')->on('alumni')->onDelete('cascade');
            $table->foreign('skill_id')->references('skill_id')->on('skills')->onDelete('cascade');
            
            $table->unique(['alumni_id', 'skill_id']);
            $table->index('alumni_id');
            $table->index('skill_id');
            $table->index('proficiency_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_skills');
    }
};
