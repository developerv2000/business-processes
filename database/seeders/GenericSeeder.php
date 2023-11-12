<?php

namespace Database\Seeders;

use App\Models\Generic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenericSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Generic::factory()->count(40)->create();
    }
}
