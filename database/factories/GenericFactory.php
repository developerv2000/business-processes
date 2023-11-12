<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\ExpirationDate;
use App\Models\Manufacturer;
use App\Models\Mnn;
use App\Models\ProductCategory;
use App\Models\ProductForm;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Generic>
 */
class GenericFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'manufacturer_id' => Manufacturer::inRandomOrder()->first()->id,
            'mnn_id' => Mnn::inRandomOrder()->first()->id,
            'brand' => fake()->name(),
            'form_id' => ProductForm::inRandomOrder()->first()->id,
            'category_id' => ProductCategory::inRandomOrder()->first()->id,
            'dose' => fake()->sentences(1, true),
            'pack' => fake()->numberBetween(10, 1000) . ' ML',
            'minimum_volume' => fake()->numberBetween(10, 1000),
            'expiration_date_id' => ExpirationDate::inRandomOrder()->first()->id,
            'dossier' => fake()->sentences(2, true),
            'bioequivalence' => fake()->name() . ' ' . fake()->numberBetween(1, 5000),
            'additional_payment' => fake()->numberBetween(1, 10000) . '$',
            'info' => fake()->sentences(3, true),
            'relationships' => fake()->sentences(2, true),
            'patent_expiry' => fake()->dateTimeBetween('-10 year', 'now'),
            'registered_in_eu' => fake()->boolean(),
            'marketed_in_eu' => fake()->boolean(),
            'created_at' => fake()->dateTimeBetween('-10 year', 'now')
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($generic) {
            $generic->zones()->attach(rand(1, Zone::count()));

            $generic->comments()->saveMany([
                new Comment(['body' => fake()->sentences(2, true), 'user_id' => User::analysts()->inRandomOrder()->first()->id, 'created_at' => now()]),
                new Comment(['body' => fake()->sentences(2, true), 'user_id' => User::analysts()->inRandomOrder()->first()->id, 'created_at' => now()]),
            ]);
        });
    }
}
