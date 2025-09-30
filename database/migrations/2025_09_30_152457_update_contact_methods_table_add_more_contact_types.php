<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change the contact_type enum to include all the types we use in the form
        DB::statement("ALTER TABLE contact_methods MODIFY contact_type ENUM('email', 'phone', 'whatsapp', 'linkedin', 'instagram', 'facebook', 'twitter', 'youtube', 'tiktok', 'github', 'website', 'other')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original enum values
        DB::statement("ALTER TABLE contact_methods MODIFY contact_type ENUM('email', 'phone', 'linkedin', 'instagram', 'facebook', 'twitter', 'website')");
    }
};
