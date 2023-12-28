<?php

namespace Database\Seeders;

use App\Models\KvppSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KvppSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['ye', 'yye', 'y'];

        for ($i = 0; $i < count($name); $i++) {
            $item = new KvppSource();
            $item->name = $name[$i];
            $item->save();
        }
    }
}
