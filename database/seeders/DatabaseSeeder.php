<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ManufacturerCategorySeeder::class,
            CountrySeeder::class,
            ZoneSeeder::class,
            ProductCategorySeeder::class,
            ProductFormSeeder::class,
            ExpirationDateSeeder::class,
            BlacklistSeeder::class,
            MnnSeeder::class,
            CurrencySeeder::class,
            ProcessStatusSeeder::class,
            CountryCodeSeeder::class,
            ProcessOwnerSeeder::class,
            ManufacturerSeeder::class,
            GenericSeeder::class,
            ProcessSeeder::class,
        ]);
    }
}
