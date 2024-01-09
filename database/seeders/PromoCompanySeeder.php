<?php

namespace Database\Seeders;

use App\Models\PromoCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['S', 'B', 'V', 'T', 'L', 'BO', 'G', 'N', 'Обсуждается'];

        for ($i = 0; $i < count($name); $i++) {
            $item = new PromoCompany();
            $item->name = $name[$i];
            $item->save();
        }
    }
}
