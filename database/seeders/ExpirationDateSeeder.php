<?php

namespace Database\Seeders;

use App\Models\ExpirationDate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpirationDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $limit = ['12', '18', '24', '36', '48', '60', 'onGoing'];

        for ($i = 0; $i < count($limit); $i++) {
            $item = new ExpirationDate();
            $item->limit = $limit[$i];
            $item->save();
        }
    }
}
