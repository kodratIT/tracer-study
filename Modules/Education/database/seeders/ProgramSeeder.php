<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, create departments
        $departments = [
            // UI - Fakultas Teknik (faculty_id: 1)
            ['department_name' => 'Teknik Informatika', 'faculty_id' => 1],
            ['department_name' => 'Teknik Elektro', 'faculty_id' => 1],
            ['department_name' => 'Teknik Sipil', 'faculty_id' => 1],
            
            // UI - Fakultas Ilmu Komputer (faculty_id: 2)
            ['department_name' => 'Ilmu Komputer', 'faculty_id' => 2],
            ['department_name' => 'Sistem Informasi', 'faculty_id' => 2],
            
            // UI - Fakultas Ekonomi dan Bisnis (faculty_id: 3)
            ['department_name' => 'Manajemen', 'faculty_id' => 3],
            ['department_name' => 'Akuntansi', 'faculty_id' => 3],
            
            // ITB - STEI (faculty_id: 6)
            ['department_name' => 'Teknik Informatika', 'faculty_id' => 6],
            ['department_name' => 'Sistem dan Teknologi Informasi', 'faculty_id' => 6],
            ['department_name' => 'Teknik Telekomunikasi', 'faculty_id' => 6],
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'department_name' => $department['department_name'],
                'faculty_id' => $department['faculty_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Then, create programs
        $programs = [
            // Teknik Informatika UI (department_id: 1)
            ['program_name' => 'S1 Teknik Informatika', 'department_id' => 1, 'degree_level' => 'S1'],
            ['program_name' => 'S2 Teknik Informatika', 'department_id' => 1, 'degree_level' => 'S2'],
            
            // Teknik Elektro UI (department_id: 2)
            ['program_name' => 'S1 Teknik Elektro', 'department_id' => 2, 'degree_level' => 'S1'],
            
            // Teknik Sipil UI (department_id: 3)
            ['program_name' => 'S1 Teknik Sipil', 'department_id' => 3, 'degree_level' => 'S1'],
            
            // Ilmu Komputer UI (department_id: 4)
            ['program_name' => 'S1 Ilmu Komputer', 'department_id' => 4, 'degree_level' => 'S1'],
            ['program_name' => 'S2 Ilmu Komputer', 'department_id' => 4, 'degree_level' => 'S2'],
            ['program_name' => 'S3 Ilmu Komputer', 'department_id' => 4, 'degree_level' => 'S3'],
            
            // Sistem Informasi UI (department_id: 5)
            ['program_name' => 'S1 Sistem Informasi', 'department_id' => 5, 'degree_level' => 'S1'],
            
            // Manajemen UI (department_id: 6)
            ['program_name' => 'S1 Manajemen', 'department_id' => 6, 'degree_level' => 'S1'],
            ['program_name' => 'S2 Manajemen', 'department_id' => 6, 'degree_level' => 'S2'],
            
            // Akuntansi UI (department_id: 7)
            ['program_name' => 'S1 Akuntansi', 'department_id' => 7, 'degree_level' => 'S1'],
            
            // ITB Programs (department_id: 8, 9, 10)
            ['program_name' => 'S1 Teknik Informatika', 'department_id' => 8, 'degree_level' => 'S1'],
            ['program_name' => 'S1 Sistem dan Teknologi Informasi', 'department_id' => 9, 'degree_level' => 'S1'],
            ['program_name' => 'S1 Teknik Telekomunikasi', 'department_id' => 10, 'degree_level' => 'S1'],
        ];

        foreach ($programs as $program) {
            DB::table('programs')->insert([
                'program_name' => $program['program_name'],
                'department_id' => $program['department_id'],
                'degree_level' => $program['degree_level'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
