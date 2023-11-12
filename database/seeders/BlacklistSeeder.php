<?php

namespace Database\Seeders;

use App\Models\Blacklist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlacklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = [
            Blacklist::NO_CONTACT_INFO,
            Blacklist::NO_INTERESTING_PD,
            Blacklist::MARKETS,
            Blacklist::PRICES,
            Blacklist::LICENSE_FEE,
            Blacklist::BUSINESS_MODEL,
            Blacklist::DOSSIER_AND_OTHER_DOCS,
            Blacklist::CDMO,
            Blacklist::API_MFG,
        ];

        for ($i = 0; $i < count($name); $i++) {
            $item = new Blacklist();
            $item->name = $name[$i];
            $item->save();
        }
    }
}
