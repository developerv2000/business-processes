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
            'Фариз',
            'Фариз на КК',
            'Худойдод',
            'Худойдод на КК',
            'Дарья',
            'Дарья на КК',
            'Ирини',
            'Ирини на КК',
            'Фирдавс',
            'Фирдавс на КК',
            'Бехруз',
            'Бехруз на КК',
            'Фаррух',
            'Фаррух на КК',
            'Акмал',
            'Азим',
            'Мухаммад',
            'Азиз',
            'Мехродж',
            'Нозим',
            'Джахонгир',
            'Джахонгир на КК',
        ];

        for ($i = 0; $i < count($name); $i++) {
            $item = new ProcessOwner();
            $item->name = $name[$i];
            $item->save();
        }
    }
}
