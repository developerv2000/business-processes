<?php

namespace Database\Seeders;

use App\Models\ProcessOwner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = [
            'Акаи Фариз',
            'Акаи Фариз на КК',
            'Акаи Худойдод',
            'Акаи Худойдод на КК',
            'Дарья',
            'Дарья на КК',
            'Ирини',
            'Ирини на КК',
            'Акаи Фирдавс',
            'Акаи Фирдавс на КК',
            'Акаи Бехруз',
            'Акаи Бехруз на КК',
            'Акаи Фаррух',
            'Акаи Фаррух на КК',
            'Акаи Акмал',
            'Акаи Азим',
            'Акаи Мухаммад',
            'Акаи Азиз',
            'Акаи Мехродж',
            'Акаи Нозим',
            'Акаи Джахонгир',
            'Акаи Джахонгир на КК',
        ];

        for ($i = 0; $i < count($name); $i++) {
            $item = new ProcessOwner();
            $item->name = $name[$i];
            $item->save();
        }
    }
}
