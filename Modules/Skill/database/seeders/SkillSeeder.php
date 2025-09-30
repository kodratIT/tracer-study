<?php

namespace Modules\Skill\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Technical Skills
            ['skill_name' => 'PHP Programming', 'skill_category' => 'technical', 'description' => 'Server-side programming language'],
            ['skill_name' => 'Laravel Framework', 'skill_category' => 'technical', 'description' => 'PHP web application framework'],
            ['skill_name' => 'JavaScript', 'skill_category' => 'technical', 'description' => 'Client-side programming language'],
            ['skill_name' => 'React.js', 'skill_category' => 'technical', 'description' => 'JavaScript library for building user interfaces'],
            ['skill_name' => 'Vue.js', 'skill_category' => 'technical', 'description' => 'Progressive JavaScript framework'],
            ['skill_name' => 'Node.js', 'skill_category' => 'technical', 'description' => 'JavaScript runtime for server-side development'],
            ['skill_name' => 'Python', 'skill_category' => 'technical', 'description' => 'High-level programming language'],
            ['skill_name' => 'Java', 'skill_category' => 'technical', 'description' => 'Object-oriented programming language'],
            ['skill_name' => 'MySQL', 'skill_category' => 'technical', 'description' => 'Relational database management system'],
            ['skill_name' => 'PostgreSQL', 'skill_category' => 'technical', 'description' => 'Advanced relational database'],
            ['skill_name' => 'MongoDB', 'skill_category' => 'technical', 'description' => 'NoSQL document database'],
            ['skill_name' => 'Git Version Control', 'skill_category' => 'technical', 'description' => 'Version control system'],
            ['skill_name' => 'Docker', 'skill_category' => 'technical', 'description' => 'Containerization platform'],
            ['skill_name' => 'AWS Cloud Services', 'skill_category' => 'technical', 'description' => 'Amazon Web Services'],
            ['skill_name' => 'Linux Administration', 'skill_category' => 'technical', 'description' => 'Linux system administration'],
            
            // Soft Skills  
            ['skill_name' => 'Communication', 'skill_category' => 'soft_skill', 'description' => 'Effective verbal and written communication'],
            ['skill_name' => 'Teamwork', 'skill_category' => 'soft_skill', 'description' => 'Collaborative work abilities'],
            ['skill_name' => 'Leadership', 'skill_category' => 'soft_skill', 'description' => 'Leading and motivating teams'],
            ['skill_name' => 'Problem Solving', 'skill_category' => 'soft_skill', 'description' => 'Analytical and critical thinking'],
            ['skill_name' => 'Time Management', 'skill_category' => 'soft_skill', 'description' => 'Efficient time and task management'],
            ['skill_name' => 'Adaptability', 'skill_category' => 'soft_skill', 'description' => 'Flexibility in changing environments'],
            ['skill_name' => 'Critical Thinking', 'skill_category' => 'soft_skill', 'description' => 'Logical analysis and reasoning'],
            ['skill_name' => 'Creativity', 'skill_category' => 'soft_skill', 'description' => 'Innovative and creative thinking'],
            
            // Project Management
            ['skill_name' => 'Project Management', 'skill_category' => 'soft_skill', 'description' => 'Planning and executing projects'],
            ['skill_name' => 'Agile Methodology', 'skill_category' => 'soft_skill', 'description' => 'Agile project management approach'],
            ['skill_name' => 'Scrum', 'skill_category' => 'soft_skill', 'description' => 'Scrum framework for project management'],
            
            // Language Skills
            ['skill_name' => 'English', 'skill_category' => 'language', 'description' => 'English language proficiency'],
            ['skill_name' => 'Indonesian', 'skill_category' => 'language', 'description' => 'Indonesian language proficiency'],
            ['skill_name' => 'Mandarin', 'skill_category' => 'language', 'description' => 'Chinese Mandarin language'],
            ['skill_name' => 'Japanese', 'skill_category' => 'language', 'description' => 'Japanese language proficiency'],
            
            // Certifications
            ['skill_name' => 'AWS Certified Solutions Architect', 'skill_category' => 'certification', 'description' => 'AWS certification for solution architecture'],
            ['skill_name' => 'Google Cloud Professional', 'skill_category' => 'certification', 'description' => 'Google Cloud Platform certification'],
            ['skill_name' => 'PMP Certification', 'skill_category' => 'certification', 'description' => 'Project Management Professional certification'],
            ['skill_name' => 'CISSP', 'skill_category' => 'certification', 'description' => 'Certified Information Systems Security Professional'],
        ];

        foreach ($skills as $skill) {
            DB::table('skills')->insert([
                'skill_name' => $skill['skill_name'],
                'skill_category' => $skill['skill_category'],
                'description' => $skill['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
