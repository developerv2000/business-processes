<?php

namespace Database\Seeders;

use App\Models\KvppStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KvppStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['Active', 'НОИ', 'НОЕ'];

        for ($i = 0; $i < count($name); $i++) {
            $item = new KvppStatus();
            $item->name = $name[$i];
            $item->save();
        }
    }
}
