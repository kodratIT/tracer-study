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

        // Run migrations first
        $this->command->info('📊 Running migrations...');
        $this->call('migrate');

        // 1. Seed basic master data
        $this->command->info('🏛️ Seeding campuses, faculties, and programs...');
        $this->call(\Modules\Education\Database\Seeders\CampusSeeder::class);
        $this->call(\Modules\Education\Database\Seeders\FacultySeeder::class);
        $this->call(\Modules\Education\Database\Seeders\ProgramSeeder::class);

        $this->command->info('💼 Seeding employers...');
        $this->call(\Modules\Employment\Database\Seeders\EmployerSeeder::class);

        $this->command->info('🛠️ Seeding skills...');
        $this->call(\Modules\Skill\Database\Seeders\SkillSeeder::class);

        $this->command->info('📋 Seeding survey questions (BAN-PT standard)...');
        $this->call(\Modules\Survey\Database\Seeders\TracerStudyQuestionSeeder::class);

        // 2. Generate alumni data
        $this->command->info('👨‍🎓 Generating 1000 alumni records...');
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
        
        for ($i = 1; $i <= 1000; $i++) {
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
                'program_id' => $faker->numberBetween(1, 14),
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
            $selectedSkills = $faker->randomElements($skillIds, $faker->numberBetween(3, 8));
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

            if ($i % 100 === 0) {
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
                $numberOfJobs = $faker->numberBetween(1, 3);
                
                for ($j = 0; $j < $numberOfJobs; $j++) {
                    $isCurrentJob = ($j === $numberOfJobs - 1) && $faker->boolean(70);
                    $startDate = $faker->dateTimeBetween('-5 years', $isCurrentJob ? '-1 month' : '-6 months');
                    $endDate = $isCurrentJob ? null : $faker->dateTimeBetween($startDate, 'now');
                    
                    $position = $faker->randomElement($positions);
                    $baseSalary = 4000000;
                    $multiplier = 1;
                    
                    if (strpos($position, 'Senior') !== false || strpos($position, 'Manager') !== false) {
                        $multiplier = 2.5;
                    }
                    
                    $salary = $baseSalary * $multiplier * $faker->randomFloat(2, 0.8, 1.5);

                    DB::table('employment_histories')->insert([
                        'alumni_id' => $alumniId,
                        'employer_id' => $faker->numberBetween(1, 40),
                        'position' => $position,
                        'department' => $faker->randomElement([
                            'Information Technology', 'Engineering', 'Product Development',
                            'Marketing', 'Sales', 'Human Resources', 'Finance', 'Operations'
                        ]),
                        'employment_type' => $faker->randomElement(['full_time', 'part_time', 'contract', 'freelance']),
                        'start_date' => $startDate->format('Y-m-d'),
                        'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
                        'salary' => (int) $salary,
                        'employment_status' => $isCurrentJob ? 'employed' : $faker->randomElement(['resigned', 'contract_ended']),
                        'job_description' => $faker->paragraph(2),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
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
