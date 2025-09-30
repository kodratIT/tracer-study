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
        Schema::create('education_histories', function (Blueprint $table) {
            $table->id('education_history_id');
            $table->unsignedBigInteger('alumni_id');
            $table->unsignedBigInteger('program_id')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->text('thesis_title')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('alumni_id')->references('alumni_id')->on('alumni')->onDelete('cascade');
            $table->foreign('program_id')->references('program_id')->on('programs')->onDelete('set null');
            $table->index('alumni_id');
            $table->index('program_id');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_histories');
    }
};
