<?php

namespace Database\Seeders;

use App\Models\Mnn;
use App\Support\Helper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MnnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = Helper::parseMnnsFromExcel();

        foreach($names as $name) {
            $item = new Mnn();
            $item->name = $name;
            $item->save();
        }
    }
}
