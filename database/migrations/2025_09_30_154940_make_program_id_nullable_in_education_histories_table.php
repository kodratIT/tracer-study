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
        Schema::table('education_histories', function (Blueprint $table) {
            // Make program_id nullable and drop foreign key constraint
            $table->dropForeign(['program_id']);
            $table->unsignedBigInteger('program_id')->nullable()->change();
            
            // Add back foreign key constraint but allow nulls
            $table->foreign('program_id')->references('program_id')->on('programs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_histories', function (Blueprint $table) {
            // Revert back to non-nullable and original constraint
            $table->dropForeign(['program_id']);
            $table->unsignedBigInteger('program_id')->nullable(false)->change();
            $table->foreign('program_id')->references('program_id')->on('programs')->onDelete('cascade');
        });
    }
};
