<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run Shield seeder first to create users with proper roles
        $this->call(ShieldSeeder::class);

        // Run comprehensive tracer study seeding
        $this->call(TracerStudySeeder::class);
    }
}
