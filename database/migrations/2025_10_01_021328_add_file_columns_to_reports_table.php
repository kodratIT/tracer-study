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
        Schema::table('reports', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('status');
            $table->bigInteger('file_size')->nullable()->after('file_path');
            $table->timestamp('completed_at')->nullable()->after('file_size');
            $table->text('error_message')->nullable()->after('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_size', 'completed_at', 'error_message']);
        });
    }
};
