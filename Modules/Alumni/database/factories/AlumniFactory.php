<?php

namespace Modules\Alumni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class AlumniFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Alumni\Models\Alumni::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $graduationYears = [2020, 2021, 2022, 2023, 2024];
        $genders = ['male', 'female'];
        
        // Generate a unique NIM based on year and random number
        $year = $this->faker->randomElement($graduationYears);
        $nim = $year . str_pad($this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT);
        
        return [
            'student_id' => $nim,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement($genders),
            'birth_date' => $this->faker->dateTimeBetween('1995-01-01', '2002-12-31')->format('Y-m-d'),
            'graduation_year' => $year,
            'gpa' => $this->faker->randomFloat(2, 2.50, 4.00),
            'program_id' => $this->faker->numberBetween(1, 14), // Based on our program seeder
            'address_id' => null, // Will be set after creating address
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function ($alumni) {
            // Create address for alumni
            $address = \Illuminate\Support\Facades\DB::table('addresses')->insertGetId([
                'street' => $this->faker->streetAddress(),
                'city' => $this->faker->city(),
                'province' => $this->faker->randomElement([
                    'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 
                    'Yogyakarta', 'Banten', 'Sumatera Utara', 'Sumatera Barat',
                    'Sulawesi Selatan', 'Bali'
                ]),
                'postal_code' => $this->faker->postcode(),
                'country' => 'Indonesia',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update alumni with address_id
            \Illuminate\Support\Facades\DB::table('alumni')
                ->where('alumni_id', $alumni->alumni_id)
                ->update(['address_id' => $address]);

            // Create contact methods
            $contactTypes = ['email', 'phone', 'linkedin', 'instagram'];
            $selectedTypes = $this->faker->randomElements($contactTypes, $this->faker->numberBetween(1, 3));
            
            foreach ($selectedTypes as $index => $type) {
                $value = '';
                switch ($type) {
                    case 'email':
                        $value = $alumni->email;
                        break;
                    case 'phone':
                        $value = $alumni->phone;
                        break;
                    case 'linkedin':
                        $value = 'https://linkedin.com/in/' . str_replace(' ', '', strtolower($alumni->name));
                        break;
                    case 'instagram':
                        $value = '@' . str_replace(' ', '_', strtolower($alumni->name));
                        break;
                }

                \Illuminate\Support\Facades\DB::table('contact_methods')->insert([
                    'alumni_id' => $alumni->alumni_id,
                    'contact_type' => $type,
                    'contact_value' => $value,
                    'is_primary' => $index === 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Assign random skills to alumni
            $skillIds = \Illuminate\Support\Facades\DB::table('skills')->pluck('skill_id')->toArray();
            $selectedSkills = $this->faker->randomElements($skillIds, $this->faker->numberBetween(3, 8));
            $proficiencyLevels = ['beginner', 'intermediate', 'advanced', 'expert'];

            foreach ($selectedSkills as $skillId) {
                \Illuminate\Support\Facades\DB::table('alumni_skills')->insert([
                    'alumni_id' => $alumni->alumni_id,
                    'skill_id' => $skillId,
                    'proficiency_level' => $this->faker->randomElement($proficiencyLevels),
                    'notes' => $this->faker->optional(0.3)->sentence(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
