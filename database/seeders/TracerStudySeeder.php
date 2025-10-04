<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TracerStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting Tracer Study Database Seeding...');

        // Note: Migrations should be run before seeding
        // Skipping migration call in seeder - run `php artisan migrate` first

        // 1. Seed basic master data
        $this->command->info('🏛️ Seeding campuses, faculties, and programs...');
        $this->seedEducationData();

        $this->command->info('💼 Seeding employers...');
        $this->seedEmployers();

        $this->command->info('🛠️ Seeding skills...');
        $this->seedSkills();

        $this->command->info('📋 Seeding survey questions (BAN-PT standard)...');
        $this->seedSurveyQuestions();

        // 2. Generate alumni data
        $this->command->info('👨‍🎓 Generating 50 alumni records...');
        $this->generateAlumniData();

        // 3. Generate employment history
        $this->command->info('💼 Generating employment history...');
        $this->generateEmploymentHistory();

        // 4. Generate survey responses
        $this->command->info('📝 Generating survey responses...');
        $this->generateSurveyResponses();

        $this->command->info('✅ Tracer Study Database Seeding Completed!');
        $this->showSummary();
    }

    private function generateAlumniData()
    {
        // We need to create alumni manually with proper models
        $faker = \Faker\Factory::create('id_ID');
        $graduationYears = [2020, 2021, 2022, 2023, 2024];
        $genders = ['male', 'female'];
        
        for ($i = 1; $i <= 50; $i++) {
            $year = $faker->randomElement($graduationYears);
            $nim = $year . str_pad($i, 4, '0', STR_PAD_LEFT);
            
            // Create address first
            $addressId = DB::table('addresses')->insertGetId([
                'street' => $faker->streetAddress(),
                'city' => $faker->city(),
                'province' => $faker->randomElement([
                    'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 
                    'Yogyakarta', 'Banten', 'Sumatera Utara', 'Sumatera Barat',
                    'Sulawesi Selatan', 'Bali'
                ]),
                'postal_code' => $faker->postcode(),
                'country' => 'Indonesia',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create alumni
            $alumniId = DB::table('alumni')->insertGetId([
                'student_id' => $nim,
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'gender' => $faker->randomElement($genders),
                'birth_date' => $faker->dateTimeBetween('1995-01-01', '2002-12-31')->format('Y-m-d'),
                'graduation_year' => $year,
                'gpa' => $faker->randomFloat(2, 2.50, 4.00),
                'program_id' => $faker->numberBetween(1, 5),
                'address_id' => $addressId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create contact methods
            $contactTypes = ['email', 'phone', 'linkedin', 'instagram'];
            $selectedTypes = $faker->randomElements($contactTypes, $faker->numberBetween(1, 3));
            
            foreach ($selectedTypes as $index => $type) {
                $value = '';
                switch ($type) {
                    case 'email':
                        $value = DB::table('alumni')->where('alumni_id', $alumniId)->value('email');
                        break;
                    case 'phone':
                        $value = DB::table('alumni')->where('alumni_id', $alumniId)->value('phone');
                        break;
                    case 'linkedin':
                        $name = DB::table('alumni')->where('alumni_id', $alumniId)->value('name');
                        $value = 'https://linkedin.com/in/' . str_replace(' ', '', strtolower($name));
                        break;
                    case 'instagram':
                        $name = DB::table('alumni')->where('alumni_id', $alumniId)->value('name');
                        $value = '@' . str_replace(' ', '_', strtolower($name));
                        break;
                }

                DB::table('contact_methods')->insert([
                    'alumni_id' => $alumniId,
                    'contact_type' => $type,
                    'contact_value' => $value,
                    'is_primary' => $index === 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Assign random skills
            $skillIds = DB::table('skills')->pluck('skill_id')->toArray();
            $selectedSkills = $faker->randomElements($skillIds, $faker->numberBetween(2, min(6, count($skillIds))));
            $proficiencyLevels = ['beginner', 'intermediate', 'advanced', 'expert'];

            foreach ($selectedSkills as $skillId) {
                try {
                    DB::table('alumni_skills')->insert([
                        'alumni_id' => $alumniId,
                        'skill_id' => $skillId,
                        'proficiency_level' => $faker->randomElement($proficiencyLevels),
                        'notes' => $faker->optional(0.3)->sentence(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    // Skip if duplicate combination
                    continue;
                }
            }

            if ($i % 10 === 0) {
                $this->command->info("Generated $i alumni records...");
            }
        }
    }

    private function generateEmploymentHistory()
    {
        $faker = \Faker\Factory::create('id_ID');
        $alumniIds = DB::table('alumni')->pluck('alumni_id')->toArray();
        
        $positions = [
            'Software Engineer', 'Senior Software Engineer', 'Full Stack Developer', 
            'Frontend Developer', 'Backend Developer', 'Mobile Developer',
            'Data Analyst', 'Data Scientist', 'Machine Learning Engineer',
            'Product Manager', 'Project Manager', 'Business Analyst',
            'UI/UX Designer', 'Graphic Designer', 'Digital Marketing Specialist',
            'System Administrator', 'DevOps Engineer', 'Cloud Engineer',
            'Cybersecurity Analyst', 'Database Administrator', 'IT Support',
            'Quality Assurance Engineer', 'Technical Writer', 'Sales Executive'
        ];

        foreach ($alumniIds as $alumniId) {
            // 85% chance of having employment
            if ($faker->boolean(85)) {
                $position = $faker->randomElement($positions);
                
                $startDate = $faker->dateTimeBetween('-3 years', '-1 month');
                $isCurrentJob = $faker->boolean(60);
                
                DB::table('employment_histories')->insert([
                    'alumni_id' => $alumniId,
                    'employer_id' => $faker->numberBetween(1, 5),
                    'job_title' => $position,
                    'company_name' => $faker->company(),
                    'job_level' => $faker->randomElement(['entry', 'junior', 'mid', 'senior', 'lead', 'manager']),
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $isCurrentJob ? null : $faker->dateTimeBetween($startDate, 'now')->format('Y-m-d'),
                    'salary_range' => $faker->randomElement(['< 5 juta', '5-10 juta', '10-15 juta', '15-20 juta', '> 20 juta']),
                    'contract_type' => $faker->randomElement(['full_time', 'part_time', 'contract', 'freelance', 'internship']),
                    'employment_status' => $faker->randomElement(['employed', 'unemployed', 'studying', 'entrepreneur']),
                    'job_description' => $faker->optional()->sentence(10),
                    'is_active' => $isCurrentJob ? 1 : 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function generateSurveyResponses()
    {
        $faker = \Faker\Factory::create('id_ID');
        $alumniIds = DB::table('alumni')->pluck('alumni_id')->toArray();
        
        // 70% of alumni have responded to survey
        $respondentIds = $faker->randomElements($alumniIds, (int) (count($alumniIds) * 0.7));
        
        foreach ($respondentIds as $alumniId) {
            $status = $faker->randomElement(['completed', 'completed', 'completed', 'partial']); // 75% completed
            $submittedAt = $status === 'completed' ? $faker->dateTimeBetween('-3 months', 'now') : null;
            
            $responseId = DB::table('survey_responses')->insertGetId([
                'session_id' => 1,
                'alumni_id' => $alumniId,
                'submitted_at' => $submittedAt,
                'completion_status' => $status,
                'metadata' => json_encode([
                    'ip_address' => $faker->ipv4(),
                    'user_agent' => $faker->userAgent(),
                    'completion_percentage' => $status === 'completed' ? 100 : $faker->numberBetween(40, 90)
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($status === 'completed') {
                $this->createAnswersForResponse($responseId, $faker);
            }
        }
    }

    private function createAnswersForResponse($responseId, $faker)
    {
        $questions = DB::table('survey_questions')
            ->where('session_id', 1)
            ->orderBy('display_order')
            ->get();

        foreach ($questions as $question) {
            $answer = [
                'response_id' => $responseId,
                'question_id' => $question->question_id,
                'option_id' => null,
                'answer_text' => null,
                'rating_value' => null,
                'additional_data' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            switch ($question->question_type) {
                case 'text':
                    $answer['answer_text'] = $this->generateTextAnswer($question->display_order, $faker);
                    break;
                case 'textarea':
                    $answer['answer_text'] = $faker->paragraph(3);
                    break;
                case 'radio':
                case 'select':
                    $options = DB::table('survey_options')
                        ->where('question_id', $question->question_id)
                        ->get();
                    if ($options->count() > 0) {
                        $answer['option_id'] = $options->random()->option_id;
                    }
                    break;
                case 'checkbox':
                    $options = DB::table('survey_options')
                        ->where('question_id', $question->question_id)
                        ->get();
                    if ($options->count() > 0) {
                        $selectedOptions = $options->random($faker->numberBetween(1, min(3, $options->count())));
                        $answer['additional_data'] = json_encode([
                            'selected_options' => $selectedOptions->pluck('option_id')->toArray()
                        ]);
                    }
                    break;
                case 'rating':
                    $answer['rating_value'] = $faker->numberBetween(3, 5); // Bias towards higher ratings
                    break;
                case 'date':
                    $answer['answer_text'] = $faker->date();
                    break;
            }

            DB::table('answers')->insert($answer);
        }
    }

    private function generateTextAnswer($displayOrder, $faker)
    {
        switch ($displayOrder) {
            case 1: return $faker->name();
            case 2: return $faker->numerify('##########');
            case 4: return $faker->randomFloat(2, 2.50, 4.00);
            case 7: return $faker->numberBetween(0, 12);
            case 10: return $faker->city() . ', Indonesia';
            default: return $faker->sentence();
        }
    }

    private function seedEducationData()
    {
        // Seed campuses
        $campuses = [
            ['campus_name' => 'Universitas Indonesia', 'city' => 'Depok', 'province' => 'Jawa Barat'],
            ['campus_name' => 'Institut Teknologi Bandung', 'city' => 'Bandung', 'province' => 'Jawa Barat'],
            ['campus_name' => 'Universitas Gadjah Mada', 'city' => 'Yogyakarta', 'province' => 'Yogyakarta'],
            ['campus_name' => 'Institut Teknologi Sepuluh Nopember', 'city' => 'Surabaya', 'province' => 'Jawa Timur'],
            ['campus_name' => 'Universitas Brawijaya', 'city' => 'Malang', 'province' => 'Jawa Timur'],
        ];

        foreach ($campuses as $campus) {
            DB::table('campuses')->insert([
                'campus_name' => $campus['campus_name'],
                'city' => $campus['city'],
                'province' => $campus['province'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed faculties
        $faculties = [
            ['faculty_name' => 'Fakultas Teknik', 'campus_id' => 1],
            ['faculty_name' => 'Fakultas Ilmu Komputer', 'campus_id' => 1],
            ['faculty_name' => 'Sekolah Teknik Elektro dan Informatika', 'campus_id' => 2],
            ['faculty_name' => 'Fakultas Teknik', 'campus_id' => 3],
            ['faculty_name' => 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'campus_id' => 4],
        ];

        foreach ($faculties as $faculty) {
            DB::table('faculties')->insert([
                'faculty_name' => $faculty['faculty_name'],
                'campus_id' => $faculty['campus_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed departments
        $departments = [
            ['department_name' => 'Teknik Informatika', 'faculty_id' => 1],
            ['department_name' => 'Ilmu Komputer', 'faculty_id' => 2],
            ['department_name' => 'Sistem Informasi', 'faculty_id' => 2],
            ['department_name' => 'Teknik Informatika', 'faculty_id' => 3],
            ['department_name' => 'Teknik Informatika', 'faculty_id' => 4],
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'department_name' => $department['department_name'],
                'faculty_id' => $department['faculty_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed programs
        $programs = [
            ['program_name' => 'S1 Teknik Informatika', 'department_id' => 1, 'accreditation_status' => 'A', 'start_year' => 2010],
            ['program_name' => 'S1 Ilmu Komputer', 'department_id' => 2, 'accreditation_status' => 'A', 'start_year' => 2005],
            ['program_name' => 'S1 Sistem Informasi', 'department_id' => 3, 'accreditation_status' => 'B', 'start_year' => 2015],
            ['program_name' => 'S2 Ilmu Komputer', 'department_id' => 2, 'accreditation_status' => 'A', 'start_year' => 2008],
            ['program_name' => 'S1 Teknik Informatika', 'department_id' => 4, 'accreditation_status' => 'Unggul', 'start_year' => 2000],
        ];

        foreach ($programs as $program) {
            DB::table('programs')->insert([
                'program_name' => $program['program_name'],
                'department_id' => $program['department_id'],
                'accreditation_status' => $program['accreditation_status'],
                'start_year' => $program['start_year'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function seedEmployers()
    {
        $employers = [
            ['employer_name' => 'PT Gojek Indonesia', 'industry_type' => 'Technology'],
            ['employer_name' => 'PT Tokopedia', 'industry_type' => 'E-commerce'],
            ['employer_name' => 'PT Shopee International Indonesia', 'industry_type' => 'E-commerce'],
            ['employer_name' => 'PT Bank Central Asia Tbk', 'industry_type' => 'Banking'],
            ['employer_name' => 'PT Bank Mandiri (Persero) Tbk', 'industry_type' => 'Banking'],
        ];

        foreach ($employers as $employer) {
            DB::table('employers')->insert([
                'employer_name' => $employer['employer_name'],
                'industry_type' => $employer['industry_type'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function seedSkills()
    {
        $skills = [
            ['skill_name' => 'PHP Programming', 'skill_category' => 'technical', 'description' => 'Server-side programming language'],
            ['skill_name' => 'Laravel Framework', 'skill_category' => 'technical', 'description' => 'PHP web application framework'],
            ['skill_name' => 'JavaScript', 'skill_category' => 'technical', 'description' => 'Client-side programming language'],
            ['skill_name' => 'Communication', 'skill_category' => 'soft_skill', 'description' => 'Effective verbal and written communication'],
            ['skill_name' => 'Project Management', 'skill_category' => 'soft_skill', 'description' => 'Planning and executing projects'],
            ['skill_name' => 'English', 'skill_category' => 'language', 'description' => 'English language proficiency'],
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

    private function seedSurveyQuestions()
    {
        // Create default tracer study session
        $sessionId = DB::table('tracer_study_sessions')->insertGetId([
            'year' => 2024,
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'description' => 'Tracer Study Alumni 2024 - Standar BAN-PT',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $questions = [
            ['question_text' => 'Nama Lengkap', 'question_type' => 'text', 'display_order' => 1, 'is_required' => true],
            ['question_text' => 'NIM', 'question_type' => 'text', 'display_order' => 2, 'is_required' => true],
            ['question_text' => 'Tahun Lulus', 'question_type' => 'select', 'display_order' => 3, 'is_required' => true],
            ['question_text' => 'Berapa lama waktu tunggu Anda untuk memperoleh pekerjaan pertama? (dalam bulan)', 'question_type' => 'text', 'display_order' => 4, 'is_required' => true],
            ['question_text' => 'Seberapa erat hubungan antara bidang studi dengan pekerjaan Anda?', 'question_type' => 'radio', 'display_order' => 5, 'is_required' => true],
        ];

        foreach ($questions as $question) {
            DB::table('survey_questions')->insert([
                'session_id' => $sessionId,
                'question_text' => $question['question_text'],
                'question_type' => $question['question_type'],
                'display_order' => $question['display_order'],
                'is_required' => $question['is_required'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function showSummary()
    {
        $this->command->info('📈 Database Summary:');
        $this->command->table(
            ['Table', 'Records'],
            [
                ['Campuses', DB::table('campuses')->count()],
                ['Faculties', DB::table('faculties')->count()],
                ['Departments', DB::table('departments')->count()],
                ['Programs', DB::table('programs')->count()],
                ['Skills', DB::table('skills')->count()],
                ['Employers', DB::table('employers')->count()],
                ['Alumni', DB::table('alumni')->count()],
                ['Addresses', DB::table('addresses')->count()],
                ['Contact Methods', DB::table('contact_methods')->count()],
                ['Alumni Skills', DB::table('alumni_skills')->count()],
                ['Employment Histories', DB::table('employment_histories')->count()],
                ['Survey Sessions', DB::table('tracer_study_sessions')->count()],
                ['Survey Questions', DB::table('survey_questions')->count()],
                ['Survey Options', DB::table('survey_options')->count()],
                ['Survey Responses', DB::table('survey_responses')->count()],
                ['Answers', DB::table('answers')->count()],
            ]
        );
    }
}
