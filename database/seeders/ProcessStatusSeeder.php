<?php

namespace Database\Seeders;

use App\Models\ProcessStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Parents
        $parents = ['ВП', 'ПО', 'АЦ', 'СЦ', 'Кк', 'КД', 'НПР', 'Р'];

        for ($i = 0; $i < count($parents); $i++) {
            $item = new ProcessStatus();
            $item->name = $parents[$i];
            $item->save();
        }

        // Childs
        $childs = [
            'Вб – продукт выбрано (это от начало ВБ до СЦ)', 'SВб – стоп выбранный продукт', 'ПО', 'SПО', 'АЦ', 'SАЦ', 'СЦ', 'SСЦ', 'ПцКк – идет процесс Кк',
            'SКк – стоп процесс Кк', 'Кк – контракт подписан', 'ПцКД', 'SКД', 'ПцР – идет процесс Р', 'SПцР – стоп процесс Р', 'РУ – регистрация получено'
        ];
        $parent_id = [1, 1, 2, 2, 3, 3, 4, 4, 4, 4, 5, 6, 6, 7, 7, 8];

        for ($i = 0; $i < count($childs); $i++) {
            $item = new ProcessStatus();
            $item->name = $childs[$i];
            $item->parent_id = $parent_id[$i];
            $item->save();
        }
    }
}
