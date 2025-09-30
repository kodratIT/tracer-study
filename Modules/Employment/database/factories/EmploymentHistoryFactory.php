<?php

namespace Modules\Employment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class EmploymentHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Employment\Models\EmploymentHistory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $positions = [
            'Software Engineer', 'Senior Software Engineer', 'Full Stack Developer', 
            'Frontend Developer', 'Backend Developer', 'Mobile Developer',
            'Data Analyst', 'Data Scientist', 'Machine Learning Engineer',
            'Product Manager', 'Project Manager', 'Business Analyst',
            'UI/UX Designer', 'Graphic Designer', 'Digital Marketing Specialist',
            'System Administrator', 'DevOps Engineer', 'Cloud Engineer',
            'Cybersecurity Analyst', 'Database Administrator', 'IT Support',
            'Quality Assurance Engineer', 'Technical Writer', 'Sales Executive',
            'Account Manager', 'Human Resources Specialist', 'Financial Analyst'
        ];

        $employmentStatuses = ['employed', 'resigned', 'terminated', 'contract_ended'];
        $employmentTypes = ['full_time', 'part_time', 'contract', 'internship', 'freelance'];

        $startDate = $this->faker->dateTimeBetween('-5 years', '-6 months');
        $isCurrentJob = $this->faker->boolean(60); // 60% chance of current job
        $endDate = $isCurrentJob ? null : $this->faker->dateTimeBetween($startDate, 'now');

        // Salary ranges based on position level
        $position = $this->faker->randomElement($positions);
        $baseSalary = 4000000; // 4 million base
        $multiplier = 1;
        
        if (strpos($position, 'Senior') !== false || strpos($position, 'Manager') !== false) {
            $multiplier = 2.5;
        } elseif (strpos($position, 'Lead') !== false || strpos($position, 'Principal') !== false) {
            $multiplier = 3.5;
        }

        $salary = $baseSalary * $multiplier * $this->faker->randomFloat(2, 0.8, 1.5);

        return [
            'alumni_id' => null, // Will be set when creating
            'employer_id' => $this->faker->numberBetween(1, 40), // Based on our employer seeder
            'position' => $position,
            'department' => $this->faker->randomElement([
                'Information Technology', 'Engineering', 'Product Development',
                'Marketing', 'Sales', 'Human Resources', 'Finance', 'Operations',
                'Research and Development', 'Customer Service', 'Quality Assurance'
            ]),
            'employment_type' => $this->faker->randomElement($employmentTypes),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
            'salary' => (int) $salary,
            'employment_status' => $isCurrentJob ? 'employed' : $this->faker->randomElement($employmentStatuses),
            'job_description' => $this->faker->paragraph(3),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Create employment history for a specific alumni
     */
    public function forAlumni($alumniId)
    {
        return $this->state(function () use ($alumniId) {
            return [
                'alumni_id' => $alumniId,
            ];
        });
    }

    /**
     * Create current employment
     */
    public function current()
    {
        return $this->state(function () {
            return [
                'end_date' => null,
                'employment_status' => 'employed',
                'start_date' => $this->faker->dateTimeBetween('-2 years', '-1 month')->format('Y-m-d'),
            ];
        });
    }

    /**
     * Create past employment
     */
    public function past()
    {
        $startDate = $this->faker->dateTimeBetween('-5 years', '-1 year');
        $endDate = $this->faker->dateTimeBetween($startDate, '-6 months');
        
        return $this->state(function () use ($startDate, $endDate) {
            return [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'employment_status' => $this->faker->randomElement(['resigned', 'contract_ended', 'terminated']),
            ];
        });
    }
}
