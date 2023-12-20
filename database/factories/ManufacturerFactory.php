<?php

namespace Database\Factories;

use App\Models\Blacklist;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Meeting;
use App\Models\Presence;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Lottery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manufacturer>
 */
class ManufacturerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'category_id' => rand(1, 2),
            'website' => 'https://' . fake()->domainName(),
            'profile' => fake()->sentences(3, true),
            'relationships' => fake()->sentences(2, true),
            'country_id' => rand(1, Country::count()),
            'bdm_user_id' => User::bdms()->inRandomOrder()->first()->id,
            'analyst_user_id' => User::analysts()->inRandomOrder()->first()->id,
            'active' => fake()->boolean(),
            'important' => fake()->boolean(),
            'created_at' => fake()->dateTimeBetween('-10 year', 'now')
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function ($manufacturer) {
            $manufacturer->zones()->attach(rand(1, Zone::count()));
            $manufacturer->productCategories()->attach(rand(1, 2));
            $manufacturer->productCategories()->attach(rand(3, 4));

            $manufacturer->comments()->saveMany([
                new Comment(['body' => fake()->sentences(2, true), 'user_id' => User::analysts()->inRandomOrder()->first()->id, 'created_at' => now()]),
                new Comment(['body' => fake()->sentences(2, true), 'user_id' => User::analysts()->inRandomOrder()->first()->id, 'created_at' => now()]),
            ]);

            $manufacturer->presences()->saveMany([
                new Presence(['name' => fake()->country()]),
                new Presence(['name' => fake()->country()]),
            ]);

            Lottery::odds(1, 2)
                ->winner(function () use ($manufacturer) {
                    $manufacturer->blacklists()->attach(rand(1, Blacklist::count()));
                })
                ->choose();

            for ($year = 2016; $year < 2024; $year++) {
                Lottery::odds(1, 3)
                    ->winner(function () use ($manufacturer, $year) {
                        $meeting = new Meeting([
                            'year' => $year,
                            'who_met' => fake()->name(),
                            'plan' => fake()->sentences(3, true),
                            'topic' => fake()->sentences(2, true),
                            'result' => fake()->sentences(4, true),
                            'outside_the_exhibition' => fake()->sentences(1, true),
                        ]);

                        $manufacturer->meetings()->save($meeting);
                    })
                    ->choose();
            }
        });
    }
}
