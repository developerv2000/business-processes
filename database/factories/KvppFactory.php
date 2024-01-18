<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\CountryCode;
use App\Models\KvppPriority;
use App\Models\KvppSource;
use App\Models\KvppStatus;
use App\Models\Mnn;
use App\Models\PortfolioManager;
use App\Models\ProductForm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kvpp>
 */
class KvppFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status_id' => KvppStatus::inRandomOrder()->first()->id,
            'country_code_id' => CountryCode::inRandomOrder()->first()->id,
            'priority_id' => KvppPriority::inRandomOrder()->first()->id,
            'source_id' => KvppSource::inRandomOrder()->first()->id,
            'mnn_id' => Mnn::inRandomOrder()->first()->id,
            'form_id' => ProductForm::inRandomOrder()->first()->id,
            'dose' => fake()->sentences(1, true),
            'pack' => fake()->numberBetween(10, 1000) . ' ML',
            'info' => fake()->sentences(2, true),
            'date_of_forecast' => fake()->date(),
            'forecast_year_1' => fake()->numberBetween(10, 5000),
            'forecast_year_2' => fake()->numberBetween(10, 5000),
            'forecast_year_3' => fake()->numberBetween(10, 5000),
            'portfolio_manager_id' => PortfolioManager::inRandomOrder()->first()->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($kvpp) {
            $kvpp->comments()->saveMany([
                new Comment(['body' => fake()->sentences(2, true), 'user_id' => User::analysts()->inRandomOrder()->first()->id, 'created_at' => now()]),
                new Comment(['body' => fake()->sentences(2, true), 'user_id' => User::analysts()->inRandomOrder()->first()->id, 'created_at' => now()]),
            ]);

            $kvpp->promoCompanies()->attach(rand(1, 4));
            $kvpp->promoCompanies()->attach(rand(5, 9));
        });
    }
}
