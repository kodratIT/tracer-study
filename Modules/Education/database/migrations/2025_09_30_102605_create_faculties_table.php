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
        Schema::create('faculties', function (Blueprint $table) {
            $table->id('faculty_id');
            $table->string('faculty_name');
            $table->unsignedBigInteger('campus_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('campus_id')->references('campus_id')->on('campuses')->onDelete('cascade');
            $table->index('campus_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
