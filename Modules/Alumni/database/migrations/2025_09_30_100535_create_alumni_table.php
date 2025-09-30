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
        Schema::create('alumni', function (Blueprint $table) {
            $table->id('alumni_id');
            $table->string('student_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birth_date')->nullable();
            $table->integer('graduation_year');
            $table->decimal('gpa', 3, 2)->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['graduation_year']);
            $table->index(['program_id']);
            $table->index(['address_id']);
            $table->index('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
