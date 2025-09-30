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
        Schema::create('employers', function (Blueprint $table) {
            $table->id('employer_id');
            $table->string('employer_name');
            $table->string('industry_type');
            $table->string('website')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('address_id')->references('address_id')->on('addresses')->onDelete('set null');
            $table->index('industry_type');
            $table->index('address_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
