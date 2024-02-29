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
        // Parents (General statuses) id = [1 - 9]
        $name_for_admins = ['ВП', 'ПО', 'АЦ', 'СЦ', 'Кк', 'КД', 'НПР', 'Р', 'Зя']; // 9 parents
        $name_for_analysts = ['ВП', 'ПО', 'АЦ', 'СЦ', 'Кк', 'Кк', 'Кк', 'Кк', 'Кк'];
        $stage = [1, 2, 3, 4, 5, 6, 7, 8, 10]; // stage 9 added after
        $responsible_child_id = [10, 12, 14, 16, 20, 21, 23, 25, 26];

        for ($i = 0; $i < count($name_for_admins); $i++) {
            $item = new ProcessStatus();
            $item->name_for_admins = $name_for_admins[$i];
            $item->name_for_analysts = $name_for_analysts[$i];
            $item->stage = $stage[$i];
            $item->responsible_child_id = $responsible_child_id[$i];
            $item->save();
        }

        // Childs (Product status) id = [10 - 26]
        $name_for_admins = ['Вб', 'SВб', 'ПО', 'SПО', 'АЦ', 'SАЦ', 'СЦ', 'SСЦ', 'ПцКк', 'SКк', 'Кк', 'ПцКД', 'SКД', 'ПцР', 'SПцР', 'Р', 'Зя'];
        $name_for_analysts = ['Вб', 'SВб', 'ПО', 'SПО', 'АЦ', 'SАЦ', 'СЦ', 'SСЦ', 'ПцКк', 'SПцКк', 'Кк', 'Кк', 'Кк', 'Кк', 'Кк', 'Кк', 'Кк']; // 17
        $parent_id = [1, 1, 2, 2, 3, 3, 4, 4, 4, 5, 5, 6, 6, 7, 7, 8, 9];

        for ($i = 0; $i < count($name_for_admins); $i++) {
            $item = new ProcessStatus();
            $item->name_for_analysts = $name_for_analysts[$i];
            $item->name_for_admins = $name_for_admins[$i];
            $item->parent_id = $parent_id[$i];
            $item->save();
        }

        // New statusses added after all to save added data compability
        // Parent (General status). id = 27
        $item = new ProcessStatus();
        $item->name_for_admins = 'P-';
        $item->name_for_analysts = 'Кк';
        $item->stage = 9;
        $item->responsible_child_id = 28;
        $item->save();
        // Child. id = 28
        $item = new ProcessStatus();
        $item->name_for_admins = 'P-';
        $item->name_for_analysts = 'Кк';
        $item->parent_id = 27;
        $item->save();
    }
}
