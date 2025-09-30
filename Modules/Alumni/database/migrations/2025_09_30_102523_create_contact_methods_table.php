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
        Schema::create('contact_methods', function (Blueprint $table) {
            $table->id('contact_id');
            $table->unsignedBigInteger('alumni_id');
            $table->enum('contact_type', ['email', 'phone', 'linkedin', 'instagram', 'facebook', 'twitter', 'website']);
            $table->string('contact_value');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('alumni_id')->references('alumni_id')->on('alumni')->onDelete('cascade');
            $table->index(['alumni_id', 'contact_type']);
            $table->index(['alumni_id', 'is_primary']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_methods');
    }
};
