<?php

namespace Database\Factories;

use App\Models\CountryCode;
use App\Models\Generic;
use App\Models\ProcessStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Process>
 */
class ProcessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'generic_id' => Generic::inRandomOrder()->first()->id,
            'country_code_id' => CountryCode::inRandomOrder()->first()->id,
            'status_id' => ProcessStatus::onlyChilds()->inRandomOrder()->first()->id,
            'date' => fake()->date(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($process) {
            $process->owners()->attach(rand(1, 10));
            $process->owners()->attach(rand(11, 20));
        });
    }
}
