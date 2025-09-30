<?php

namespace Modules\Survey\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyResponseFactoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Survey\Models\SurveyResponseFactory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

