<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Alumni\Models\Alumni;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alumni::create([
            'student_id' => '20180001',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '081234567890',
            'gender' => 'male',
            'birth_date' => '1995-05-15',
            'graduation_year' => 2022,
            'gpa' => 3.75,
            'password' => Hash::make('password123'),
        ]);

        Alumni::create([
            'student_id' => '20180002',
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '081234567891',
            'gender' => 'female',
            'birth_date' => '1996-08-22',
            'graduation_year' => 2022,
            'gpa' => 3.85,
            'password' => Hash::make('password123'),
        ]);

        Alumni::create([
            'student_id' => '20190001',
            'name' => 'Bob Wilson',
            'email' => 'bob@example.com',
            'phone' => '081234567892',
            'gender' => 'male',
            'birth_date' => '1997-02-10',
            'graduation_year' => 2023,
            'gpa' => 3.65,
            'password' => Hash::make('password123'),
        ]);
    }
}
