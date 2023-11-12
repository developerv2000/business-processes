<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['ЛС', 'БАД', 'МИ', 'КОСМ'];

        for ($i = 0; $i < count($name); $i++) {
            $item = new ProductCategory();
            $item->name = $name[$i];
            $item->save();
        }
    }
}
