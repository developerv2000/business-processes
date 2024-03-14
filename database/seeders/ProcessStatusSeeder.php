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
        // Parents (General statuses) id = [1 - 9]. 9 elements
        $name_for_admins = ['ВП', 'ПО', 'АЦ', 'СЦ', 'Кк', 'КД', 'НПР', 'Р', 'Зя'];
        $name_for_analysts = ['1ВП', '2ПО', '3АЦ', '4СЦ', '5Кк', '5Кк', '5Кк', '5Кк', '5Кк'];
        $stage = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $responsible_child_id = [10, 12, 14, 16, 20, 21, 23, 25, 27];

        for ($i = 0; $i < count($name_for_admins); $i++) {
            $item = new ProcessStatus();
            $item->name_for_admins = $name_for_admins[$i];
            $item->name_for_analysts = $name_for_analysts[$i];
            $item->stage = $stage[$i];
            $item->responsible_child_id = $responsible_child_id[$i];
            $item->save();
        }

        // Childs (Product status) id = [10 - 27]. 18 elements
        $name_for_admins = ['Вб', 'SВб', 'ПО', 'SПО', 'АЦ', 'SАЦ', 'СЦ', 'SСЦ', 'ПцКк', 'SПцКк', 'Кк', 'ПцКД', 'SКД', 'ПцР', 'SПцР', 'Р', 'P-', 'Зя'];
        $name_for_analysts = ['Вб', 'SВб', 'ПО', 'SПО', 'АЦ', 'SАЦ', 'СЦ', 'SСЦ', 'ПцКк', 'SПцКк', 'Кк', 'Кк', 'Кк', 'Кк', 'Кк', 'Кк', 'Кк', 'Кк'];
        $parent_id = [1, 1, 2, 2, 3, 3, 4, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9];

        for ($i = 0; $i < count($name_for_admins); $i++) {
            $item = new ProcessStatus();
            $item->name_for_analysts = $name_for_analysts[$i];
            $item->name_for_admins = $name_for_admins[$i];
            $item->parent_id = $parent_id[$i];
            $item->save();
        }
    }
}
