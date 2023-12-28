<?php

namespace Database\Seeders;

use App\Models\PortfolioManager;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['Акмал', 'Азиз', 'Джахонгир', 'Нозим', 'Сабрина', 'Мухаммад'];

        for ($i = 0; $i < count($name); $i++) {
            $item = new PortfolioManager();
            $item->name = $name[$i];
            $item->save();
        }
    }
}
