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
        $parents = ['ВП', 'ПО', 'АЦ', 'СЦ', 'Кк', 'КД', 'НПР', 'Р', 'Зя'];
        $stage = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $responsible_child_id = [10, 12, 14, 16, 20, 21, 23, 25, 26];

        for ($i = 0; $i < count($parents); $i++) {
            $item = new ProcessStatus();
            $item->name = $parents[$i];
            $item->stage = $stage[$i];
            $item->responsible_child_id = $responsible_child_id[$i];
            $item->save();
        }

        // Childs
        $childs = ['Вб', 'SВб', 'ПО', 'SПО', 'АЦ', 'SАЦ', 'СЦ', 'SСЦ', 'ПцКк', 'SПцКк', 'Кк', 'ПцКД', 'SКД', 'ПцР', 'SПцР', 'Р', 'P-', 'Зя'];
        $parent_id = [1, 1, 2, 2, 3, 3, 4, 4, 4, 5, 5, 6, 6, 7, 7, 8, 9];

        for ($i = 0; $i < count($childs); $i++) {
            $item = new ProcessStatus();
            $item->name = $childs[$i];
            $item->parent_id = $parent_id[$i];
            $item->save();
        }
    }
}
