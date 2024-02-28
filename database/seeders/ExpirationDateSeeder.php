<?php

namespace Database\Seeders;

use App\Models\ExpirationDate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpirationDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['12', '18', '24', '36', '48', '60', 'TBC'];

        for ($i = 0; $i < count($name); $i++) {
            $item = new ExpirationDate();
            $item->name = $name[$i];
            $item->save();
        }
    }
}
