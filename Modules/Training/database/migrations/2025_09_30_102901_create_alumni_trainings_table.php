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
        Schema::create('alumni_trainings', function (Blueprint $table) {
            $table->id('alumni_training_id');
            $table->unsignedBigInteger('alumni_id');
            $table->unsignedBigInteger('training_id');
            $table->enum('status', ['registered', 'in_progress', 'completed', 'dropped', 'cancelled']);
            $table->string('score')->nullable();
            $table->date('completion_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('alumni_id')->references('alumni_id')->on('alumni')->onDelete('cascade');
            $table->foreign('training_id')->references('training_id')->on('training_courses')->onDelete('cascade');
            
            $table->unique(['alumni_id', 'training_id']);
            $table->index('alumni_id');
            $table->index('training_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_trainings');
    }
};
