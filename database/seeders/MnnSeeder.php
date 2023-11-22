<?php

namespace Database\Seeders;

use App\Models\Mnn;
use App\Support\Helper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class MnnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::environment('local')) {
            $names = ['ABIES SIBIRICA + EUCALYPTUS GLOBULUS', 'ACER NEGUNDO', 'ALBUMIN + APIS MELLIFICA', 'BROMO-D-CAMPHOR', 'BRYONIA ALBA + CAMPHOR + MAGNESIUM', 'BUDESONIDE + FORMOTEROL'];
        } else {
            $names = Helper::parseMnnsFromExcel();
        }

        foreach ($names as $name) {
            $item = new Mnn();
            $item->name = $name;
            $item->save();
        }
    }
}
