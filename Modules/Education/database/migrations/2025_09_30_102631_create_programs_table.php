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
        Schema::create('programs', function (Blueprint $table) {
            $table->id('program_id');
            $table->string('program_name');
            $table->unsignedBigInteger('department_id');
            $table->enum('accreditation_status', ['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik']);
            $table->integer('start_year');
            $table->integer('end_year')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade');
            $table->index('department_id');
            $table->index(['start_year', 'end_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
