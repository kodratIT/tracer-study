<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            // Universitas Indonesia (campus_id: 1)
            ['faculty_name' => 'Fakultas Teknik', 'campus_id' => 1],
            ['faculty_name' => 'Fakultas Ilmu Komputer', 'campus_id' => 1],
            ['faculty_name' => 'Fakultas Ekonomi dan Bisnis', 'campus_id' => 1],
            ['faculty_name' => 'Fakultas Hukum', 'campus_id' => 1],
            ['faculty_name' => 'Fakultas Kedokteran', 'campus_id' => 1],
            
            // Institut Teknologi Bandung (campus_id: 2)
            ['faculty_name' => 'Sekolah Teknik Elektro dan Informatika', 'campus_id' => 2],
            ['faculty_name' => 'Fakultas Teknik Mesin dan Dirgantara', 'campus_id' => 2],
            ['faculty_name' => 'Fakultas Teknik Sipil dan Lingkungan', 'campus_id' => 2],
            ['faculty_name' => 'Sekolah Bisnis dan Manajemen', 'campus_id' => 2],
            
            // Universitas Gadjah Mada (campus_id: 3)
            ['faculty_name' => 'Fakultas Teknik', 'campus_id' => 3],
            ['faculty_name' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam', 'campus_id' => 3],
            ['faculty_name' => 'Fakultas Ekonomika dan Bisnis', 'campus_id' => 3],
            ['faculty_name' => 'Fakultas Ilmu Sosial dan Politik', 'campus_id' => 3],
            
            // Institut Teknologi Sepuluh Nopember (campus_id: 4)
            ['faculty_name' => 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'campus_id' => 4],
            ['faculty_name' => 'Fakultas Teknik Sipil, Perencanaan, dan Kebumian', 'campus_id' => 4],
            ['faculty_name' => 'Fakultas Teknologi Industri dan Rekayasa Sistem', 'campus_id' => 4],
            
            // Universitas Brawijaya (campus_id: 5)
            ['faculty_name' => 'Fakultas Teknik', 'campus_id' => 5],
            ['faculty_name' => 'Fakultas Ilmu Komputer', 'campus_id' => 5],
            ['faculty_name' => 'Fakultas Ekonomi dan Bisnis', 'campus_id' => 5],
        ];

        foreach ($faculties as $faculty) {
            DB::table('faculties')->insert([
                'faculty_name' => $faculty['faculty_name'],
                'campus_id' => $faculty['campus_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
