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
        // Schema::table('employment_histories', function (Blueprint $table) {
        //     // Make employer_id nullable and drop foreign key constraint
        //     $table->dropForeign(['employer_id']);
        //     $table->unsignedBigInteger('employer_id')->nullable()->change();
            
        //     // Add back foreign key constraint but allow nulls
        //     $table->foreign('employer_id')->references('employer_id')->on('employers')->onDelete('set null');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('employment_histories', function (Blueprint $table) {
        //     // Revert back to non-nullable and original constraint
        //     $table->dropForeign(['employer_id']);
        //     $table->unsignedBigInteger('employer_id')->nullable(false)->change();
        //     $table->foreign('employer_id')->references('employer_id')->on('employers')->onDelete('cascade');
        // });
    }
};
