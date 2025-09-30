<?php

namespace Modules\Alumni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlumniFactoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Alumni\Models\AlumniFactory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

