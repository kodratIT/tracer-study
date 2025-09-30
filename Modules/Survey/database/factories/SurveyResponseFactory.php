<?php

namespace Modules\Survey\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class SurveyResponseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Survey\Models\SurveyResponse::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $statuses = ['draft', 'partial', 'completed'];
        $status = $this->faker->randomElement($statuses);
        
        $submittedAt = null;
        if ($status === 'completed') {
            $submittedAt = $this->faker->dateTimeBetween('-3 months', 'now');
        } elseif ($status === 'partial' && $this->faker->boolean(70)) {
            $submittedAt = $this->faker->dateTimeBetween('-1 month', 'now');
        }

        return [
            'session_id' => 1, // Default to the BAN-PT session we created
            'alumni_id' => null, // Will be set when creating
            'submitted_at' => $submittedAt,
            'completion_status' => $status,
            'metadata' => json_encode([
                'ip_address' => $this->faker->ipv4(),
                'user_agent' => $this->faker->userAgent(),
                'started_at' => $this->faker->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s'),
                'completion_percentage' => $status === 'completed' ? 100 : ($status === 'partial' ? $this->faker->numberBetween(30, 90) : $this->faker->numberBetween(5, 30))
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Create response for a specific alumni
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
     * Create completed response
     */
    public function completed()
    {
        return $this->state(function () {
            return [
                'completion_status' => 'completed',
                'submitted_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
                'metadata' => json_encode([
                    'ip_address' => $this->faker->ipv4(),
                    'user_agent' => $this->faker->userAgent(),
                    'started_at' => $this->faker->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s'),
                    'completion_percentage' => 100
                ]),
            ];
        });
    }

    /**
     * Configure the model factory to create answers
     */
    public function configure()
    {
        return $this->afterCreating(function ($response) {
            if ($response->completion_status === 'completed') {
                $this->createAnswersForResponse($response);
            }
        });
    }

    private function createAnswersForResponse($response)
    {
        // Get all questions for the session
        $questions = \Illuminate\Support\Facades\DB::table('survey_questions')
            ->where('session_id', $response->session_id)
            ->orderBy('display_order')
            ->get();

        foreach ($questions as $question) {
            $answer = [
                'response_id' => $response->response_id,
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
                    $answer['answer_text'] = $this->generateTextAnswer($question->display_order);
                    break;
                    
                case 'textarea':
                    $answer['answer_text'] = $this->faker->paragraph(3);
                    break;
                    
                case 'radio':
                case 'select':
                    $options = \Illuminate\Support\Facades\DB::table('survey_options')
                        ->where('question_id', $question->question_id)
                        ->get();
                    if ($options->count() > 0) {
                        $selectedOption = $options->random();
                        $answer['option_id'] = $selectedOption->option_id;
                    }
                    break;
                    
                case 'checkbox':
                    $options = \Illuminate\Support\Facades\DB::table('survey_options')
                        ->where('question_id', $question->question_id)
                        ->get();
                    if ($options->count() > 0) {
                        $selectedOptions = $options->random($this->faker->numberBetween(1, min(3, $options->count())));
                        $answer['additional_data'] = json_encode([
                            'selected_options' => $selectedOptions->pluck('option_id')->toArray()
                        ]);
                    }
                    break;
                    
                case 'rating':
                    $answer['rating_value'] = $this->faker->numberBetween(1, 5);
                    break;
                    
                case 'date':
                    $answer['answer_text'] = $this->faker->date();
                    break;
            }

            \Illuminate\Support\Facades\DB::table('answers')->insert($answer);
        }
    }

    private function generateTextAnswer($displayOrder)
    {
        switch ($displayOrder) {
            case 1: // Nama Lengkap
                return $this->faker->name();
            case 2: // NIM
                return $this->faker->numerify('##########');
            case 4: // IPK
                return $this->faker->randomFloat(2, 2.50, 4.00);
            case 7: // Waktu tunggu pekerjaan (bulan)
                return $this->faker->numberBetween(0, 12);
            case 10: // Lokasi tempat kerja
                return $this->faker->city() . ', ' . $this->faker->randomElement(['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang']);
            default:
                return $this->faker->sentence();
        }
    }
}
