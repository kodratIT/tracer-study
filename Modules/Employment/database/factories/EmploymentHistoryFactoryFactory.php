<?php

namespace Modules\Employment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmploymentHistoryFactoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Employment\Models\EmploymentHistoryFactory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

