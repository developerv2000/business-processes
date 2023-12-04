<?php

namespace Database\Seeders;

use App\Models\ProductForm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Parents
        $parents = ['AMPOULES', 'BATHS', 'CAPSULES', 'CARTRIDGE/PENS', 'CREAMS', 'GASES', 'GEL/SOL', 'INFUSIONS', 'LIQUIDS', 'MED.DRESSINGS', 'MEDICAL AIDS', 'OINTMENTS', 'OTHER FORMS', 'P-F SYRINGES', 'POWDER/GRANULE', 'PRESS AEROSOLS', 'SPEC.SOL.FORMS', 'SUPPOSITORIES', 'TABLETS', 'TEAS', 'VIALS'];

        for ($i = 0; $i < count($parents); $i++) {
            $item = new ProductForm();
            $item->name = $parents[$i];
            $item->save();
        }

        // Childs
        $childs = array(
            0 =>
            array(
                'name' => 'AMP INS',
                'parent_id' => 1,
            ),
            1 =>
            array(
                'name' => 'AMP PWD',
                'parent_id' => 1,
            ),
            2 =>
            array(
                'name' => 'COMB-AMP',
                'parent_id' => 1,
            ),
            3 =>
            array(
                'name' => 'EY-AMP',
                'parent_id' => 1,
            ),
            4 =>
            array(
                'name' => 'EY-AMP PWD',
                'parent_id' => 1,
            ),
            5 =>
            array(
                'name' => 'IM-AMP',
                'parent_id' => 1,
            ),
            6 =>
            array(
                'name' => 'IM-AMP-RT',
                'parent_id' => 1,
            ),
            7 =>
            array(
                'name' => 'IM-PWD',
                'parent_id' => 1,
            ),
            8 =>
            array(
                'name' => 'IM-PWD-RT',
                'parent_id' => 1,
            ),
            9 =>
            array(
                'name' => 'IV-AMP',
                'parent_id' => 1,
            ),
            10 =>
            array(
                'name' => 'IV-SOL',
                'parent_id' => 1,
            ),
            11 =>
            array(
                'name' => 'N-HUM AMP',
                'parent_id' => 1,
            ),
            12 =>
            array(
                'name' => 'OTH AMP',
                'parent_id' => 1,
            ),
            13 =>
            array(
                'name' => 'OTH AMP-RT',
                'parent_id' => 1,
            ),
            14 =>
            array(
                'name' => 'OTH TOP AMP',
                'parent_id' => 1,
            ),
            15 =>
            array(
                'name' => 'SC-AMP',
                'parent_id' => 1,
            ),
            16 =>
            array(
                'name' => 'TOP AMP',
                'parent_id' => 1,
            ),
            17 =>
            array(
                'name' => 'VG AMP',
                'parent_id' => 1,
            ),
            18 =>
            array(
                'name' => 'BATH',
                'parent_id' => 2,
            ),
            19 =>
            array(
                'name' => 'BATH EMULSION',
                'parent_id' => 2,
            ),
            20 =>
            array(
                'name' => 'BATH FOAM',
                'parent_id' => 2,
            ),
            21 =>
            array(
                'name' => 'BATH-OIL',
                'parent_id' => 2,
            ),
            22 =>
            array(
                'name' => 'BATH-PWD',
                'parent_id' => 2,
            ),
            23 =>
            array(
                'name' => 'OTH BATH',
                'parent_id' => 2,
            ),
            24 =>
            array(
                'name' => 'PART BATH',
                'parent_id' => 2,
            ),
            25 =>
            array(
                'name' => 'CAP-CACHET',
                'parent_id' => 3,
            ),
            26 =>
            array(
                'name' => 'COMB CAP',
                'parent_id' => 3,
            ),
            27 =>
            array(
                'name' => 'D-CAP',
                'parent_id' => 3,
            ),
            28 =>
            array(
                'name' => 'LUNG-CAP INH',
                'parent_id' => 3,
            ),
            29 =>
            array(
                'name' => 'NS-CAP INH',
                'parent_id' => 3,
            ),
            30 =>
            array(
                'name' => 'ORAL TOP CAP',
                'parent_id' => 3,
            ),
            31 =>
            array(
                'name' => 'OTH CAP',
                'parent_id' => 3,
            ),
            32 =>
            array(
                'name' => 'OTH CAP RT',
                'parent_id' => 3,
            ),
            33 =>
            array(
                'name' => 'RT-CAP MC',
                'parent_id' => 3,
            ),
            34 =>
            array(
                'name' => 'TC-CAP',
                'parent_id' => 3,
            ),
            35 =>
            array(
                'name' => 'TC-CAP BITE',
                'parent_id' => 3,
            ),
            36 =>
            array(
                'name' => 'TC-CAP CHW',
                'parent_id' => 3,
            ),
            37 =>
            array(
                'name' => 'TC-CAP EC',
                'parent_id' => 3,
            ),
            38 =>
            array(
                'name' => 'TC-CAP RT',
                'parent_id' => 3,
            ),
            39 =>
            array(
                'name' => 'VG-CAPS',
                'parent_id' => 3,
            ),
            40 =>
            array(
                'name' => 'CART-RT',
                'parent_id' => 4,
            ),
            41 =>
            array(
                'name' => 'CART-U',
                'parent_id' => 4,
            ),
            42 =>
            array(
                'name' => 'I-CART',
                'parent_id' => 4,
            ),
            43 =>
            array(
                'name' => 'OTH CART',
                'parent_id' => 4,
            ),
            44 =>
            array(
                'name' => 'PEN',
                'parent_id' => 4,
            ),
            45 =>
            array(
                'name' => 'PEN RT',
                'parent_id' => 4,
            ),
            46 =>
            array(
                'name' => 'PWD CART',
                'parent_id' => 4,
            ),
            47 =>
            array(
                'name' => 'PWD PEN',
                'parent_id' => 4,
            ),
            48 =>
            array(
                'name' => 'PWD PEN RT',
                'parent_id' => 4,
            ),
            49 =>
            array(
                'name' => 'COMB TAB CT',
                'parent_id' => 19,
            ),
            50 =>
            array(
                'name' => 'OTH RT-TAB',
                'parent_id' => 19,
            ),
            51 =>
            array(
                'name' => 'RT-TAB CT',
                'parent_id' => 19,
            ),
            52 =>
            array(
                'name' => 'RT-TAB EC',
                'parent_id' => 19,
            ),
            53 =>
            array(
                'name' => 'RT-TAB MC',
                'parent_id' => 19,
            ),
            54 =>
            array(
                'name' => 'TC-TAB CHW',
                'parent_id' => 19,
            ),
            55 =>
            array(
                'name' => 'TC-TAB CT',
                'parent_id' => 19,
            ),
            56 =>
            array(
                'name' => 'TC-TAB EC',
                'parent_id' => 19,
            ),
            57 =>
            array(
                'name' => 'TC-TAB FC',
                'parent_id' => 19,
            ),
            58 =>
            array(
                'name' => 'TC-TAB GC',
                'parent_id' => 19,
            ),
            59 =>
            array(
                'name' => 'TC-TAB RT',
                'parent_id' => 19,
            ),
            60 =>
            array(
                'name' => 'COMB CREAM',
                'parent_id' => 5,
            ),
            61 =>
            array(
                'name' => 'COMB D-CREAM',
                'parent_id' => 5,
            ),
            62 =>
            array(
                'name' => 'D-CREAM',
                'parent_id' => 5,
            ),
            63 =>
            array(
                'name' => 'D-CREAM-MD',
                'parent_id' => 5,
            ),
            64 =>
            array(
                'name' => 'D-CREAM-U',
                'parent_id' => 5,
            ),
            65 =>
            array(
                'name' => 'D-E/CREAM',
                'parent_id' => 5,
            ),
            66 =>
            array(
                'name' => 'D-SOAP',
                'parent_id' => 5,
            ),
            67 =>
            array(
                'name' => 'EY-CRM',
                'parent_id' => 5,
            ),
            68 =>
            array(
                'name' => 'N-HUM CRM',
                'parent_id' => 5,
            ),
            69 =>
            array(
                'name' => 'NS-CRM',
                'parent_id' => 5,
            ),
            70 =>
            array(
                'name' => 'ORAL CREAM',
                'parent_id' => 5,
            ),
            71 =>
            array(
                'name' => 'OTH D-SOAP',
                'parent_id' => 5,
            ),
            72 =>
            array(
                'name' => 'SYS CREAM',
                'parent_id' => 5,
            ),
            73 =>
            array(
                'name' => 'VG-COMB',
                'parent_id' => 5,
            ),
            74 =>
            array(
                'name' => 'VG-CRM',
                'parent_id' => 5,
            ),
            75 =>
            array(
                'name' => 'VG-CRM-U',
                'parent_id' => 5,
            ),
            76 =>
            array(
                'name' => 'SYS GAS',
                'parent_id' => 6,
            ),
            77 =>
            array(
                'name' => 'COMB GEL',
                'parent_id' => 7,
            ),
            78 =>
            array(
                'name' => 'D-E/GEL',
                'parent_id' => 7,
            ),
            79 =>
            array(
                'name' => 'D-GEL',
                'parent_id' => 7,
            ),
            80 =>
            array(
                'name' => 'D-GEL-MD',
                'parent_id' => 7,
            ),
            81 =>
            array(
                'name' => 'D-GEL-U',
                'parent_id' => 7,
            ),
            82 =>
            array(
                'name' => 'D-SH/GEL',
                'parent_id' => 7,
            ),
            83 =>
            array(
                'name' => 'EY-GEL',
                'parent_id' => 7,
            ),
            84 =>
            array(
                'name' => 'EY-GEL DR',
                'parent_id' => 7,
            ),
            85 =>
            array(
                'name' => 'EY-GEL-U',
                'parent_id' => 7,
            ),
            86 =>
            array(
                'name' => 'N-HUM GEL',
                'parent_id' => 7,
            ),
            87 =>
            array(
                'name' => 'NS SYS GEL',
                'parent_id' => 7,
            ),
            88 =>
            array(
                'name' => 'NS-GEL',
                'parent_id' => 7,
            ),
            89 =>
            array(
                'name' => 'ORAL GEL',
                'parent_id' => 7,
            ),
            90 =>
            array(
                'name' => 'ORAL GEL-U',
                'parent_id' => 7,
            ),
            91 =>
            array(
                'name' => 'OTH D-GEL',
                'parent_id' => 7,
            ),
            92 =>
            array(
                'name' => 'OTH SYS GEL',
                'parent_id' => 7,
            ),
            93 =>
            array(
                'name' => 'RECT GEL',
                'parent_id' => 7,
            ),
            94 =>
            array(
                'name' => 'SYS GEL-MD',
                'parent_id' => 7,
            ),
            95 =>
            array(
                'name' => 'SYS GEL-U',
                'parent_id' => 7,
            ),
            96 =>
            array(
                'name' => 'VG-GEL',
                'parent_id' => 7,
            ),
            97 =>
            array(
                'name' => 'VG-GEL-U',
                'parent_id' => 7,
            ),
            98 =>
            array(
                'name' => 'AMP INF',
                'parent_id' => 8,
            ),
            99 =>
            array(
                'name' => 'BAG INF',
                'parent_id' => 8,
            ),
            100 =>
            array(
                'name' => 'CART INF',
                'parent_id' => 8,
            ),
            101 =>
            array(
                'name' => 'IRR FLUID',
                'parent_id' => 8,
            ),
            102 =>
            array(
                'name' => 'OTH INF',
                'parent_id' => 8,
            ),
            103 =>
            array(
                'name' => 'PWD INF',
                'parent_id' => 8,
            ),
            104 =>
            array(
                'name' => 'VIA INF',
                'parent_id' => 8,
            ),
            105 =>
            array(
                'name' => 'VIA INF PWD',
                'parent_id' => 8,
            ),
            106 =>
            array(
                'name' => 'ALCOHOL',
                'parent_id' => 9,
            ),
            107 =>
            array(
                'name' => 'COMB LIQ',
                'parent_id' => 9,
            ),
            108 =>
            array(
                'name' => 'D-ALCOHOL',
                'parent_id' => 9,
            ),
            109 =>
            array(
                'name' => 'D-COMB-LIQ',
                'parent_id' => 9,
            ),
            110 =>
            array(
                'name' => 'D-DRY',
                'parent_id' => 9,
            ),
            111 =>
            array(
                'name' => 'D-EMULSION',
                'parent_id' => 9,
            ),
            112 =>
            array(
                'name' => 'D-ENEM',
                'parent_id' => 9,
            ),
            113 =>
            array(
                'name' => 'D-INH',
                'parent_id' => 9,
            ),
            114 =>
            array(
                'name' => 'D-LIQ-MD',
                'parent_id' => 9,
            ),
            115 =>
            array(
                'name' => 'D-LIQ-U',
                'parent_id' => 9,
            ),
            116 =>
            array(
                'name' => 'D-MIXT',
                'parent_id' => 9,
            ),
            117 =>
            array(
                'name' => 'D-OIL',
                'parent_id' => 9,
            ),
            118 =>
            array(
                'name' => 'DRY DROP',
                'parent_id' => 9,
            ),
            119 =>
            array(
                'name' => 'D-SKIN',
                'parent_id' => 9,
            ),
            120 =>
            array(
                'name' => 'D-SOL',
                'parent_id' => 9,
            ),
            121 =>
            array(
                'name' => 'D-SPR',
                'parent_id' => 9,
            ),
            122 =>
            array(
                'name' => 'D-SUSP',
                'parent_id' => 9,
            ),
            123 =>
            array(
                'name' => 'EAR-DROP',
                'parent_id' => 9,
            ),
            124 =>
            array(
                'name' => 'EAR-DROP PWD',
                'parent_id' => 9,
            ),
            125 =>
            array(
                'name' => 'EAR-SOL',
                'parent_id' => 9,
            ),
            126 =>
            array(
                'name' => 'EAR-SOL-MD',
                'parent_id' => 9,
            ),
            127 =>
            array(
                'name' => 'EAR-SOL-U',
                'parent_id' => 9,
            ),
            128 =>
            array(
                'name' => 'EAR-SUSP',
                'parent_id' => 9,
            ),
            129 =>
            array(
                'name' => 'EMULSION',
                'parent_id' => 9,
            ),
            130 =>
            array(
                'name' => 'ENEM-SOL',
                'parent_id' => 9,
            ),
            131 =>
            array(
                'name' => 'EY-COMB',
                'parent_id' => 9,
            ),
            132 =>
            array(
                'name' => 'EY-DROP',
                'parent_id' => 9,
            ),
            133 =>
            array(
                'name' => 'EY-DROP PWD',
                'parent_id' => 9,
            ),
            134 =>
            array(
                'name' => 'EY-LOTION',
                'parent_id' => 9,
            ),
            135 =>
            array(
                'name' => 'EY-SOL',
                'parent_id' => 9,
            ),
            136 =>
            array(
                'name' => 'EY-SOL-MD',
                'parent_id' => 9,
            ),
            137 =>
            array(
                'name' => 'EY-SOL-U',
                'parent_id' => 9,
            ),
            138 =>
            array(
                'name' => 'EY-SUSP',
                'parent_id' => 9,
            ),
            139 =>
            array(
                'name' => 'INH LIQ',
                'parent_id' => 9,
            ),
            140 =>
            array(
                'name' => 'INH LIQ-U',
                'parent_id' => 9,
            ),
            141 =>
            array(
                'name' => 'INH LUNG',
                'parent_id' => 9,
            ),
            142 =>
            array(
                'name' => 'INH LUNG-MD',
                'parent_id' => 9,
            ),
            143 =>
            array(
                'name' => 'INH LUNG-U',
                'parent_id' => 9,
            ),
            144 =>
            array(
                'name' => 'LOTION',
                'parent_id' => 9,
            ),
            145 =>
            array(
                'name' => 'M-D SPR',
                'parent_id' => 9,
            ),
            146 =>
            array(
                'name' => 'M-D SYS SOL',
                'parent_id' => 9,
            ),
            147 =>
            array(
                'name' => 'M-D TOP SRR',
                'parent_id' => 9,
            ),
            148 =>
            array(
                'name' => 'N-HUM DROP',
                'parent_id' => 9,
            ),
            149 =>
            array(
                'name' => 'N-HUM LIQ',
                'parent_id' => 9,
            ),
            150 =>
            array(
                'name' => 'N-HUM LIQ-U',
                'parent_id' => 9,
            ),
            151 =>
            array(
                'name' => 'NS SPR',
                'parent_id' => 9,
            ),
            152 =>
            array(
                'name' => 'NS-DROP',
                'parent_id' => 9,
            ),
            153 =>
            array(
                'name' => 'NS-INH',
                'parent_id' => 9,
            ),
            154 =>
            array(
                'name' => 'NS-OIL',
                'parent_id' => 9,
            ),
            155 =>
            array(
                'name' => 'NS-SOL',
                'parent_id' => 9,
            ),
            156 =>
            array(
                'name' => 'NS-SOL-MD',
                'parent_id' => 9,
            ),
            157 =>
            array(
                'name' => 'NS-SOL-U',
                'parent_id' => 9,
            ),
            158 =>
            array(
                'name' => 'NS-SPR w/o',
                'parent_id' => 9,
            ),
            159 =>
            array(
                'name' => 'NS-SYS DROPS-U',
                'parent_id' => 9,
            ),
            160 =>
            array(
                'name' => 'NS-SYS DRP',
                'parent_id' => 9,
            ),
            161 =>
            array(
                'name' => 'NS-SYS DRY',
                'parent_id' => 9,
            ),
            162 =>
            array(
                'name' => 'ORAL DRP',
                'parent_id' => 9,
            ),
            163 =>
            array(
                'name' => 'ORAL LIQ-U',
                'parent_id' => 9,
            ),
            164 =>
            array(
                'name' => 'ORAL OIL',
                'parent_id' => 9,
            ),
            165 =>
            array(
                'name' => 'ORAL SOL',
                'parent_id' => 9,
            ),
            166 =>
            array(
                'name' => 'ORAL SOL SUBL',
                'parent_id' => 9,
            ),
            167 =>
            array(
                'name' => 'ORAL SOL-RT',
                'parent_id' => 9,
            ),
            168 =>
            array(
                'name' => 'ORAL SPR',
                'parent_id' => 9,
            ),
            169 =>
            array(
                'name' => 'OTH LIQ',
                'parent_id' => 9,
            ),
            170 =>
            array(
                'name' => 'OTH SPR w/o',
                'parent_id' => 9,
            ),
            171 =>
            array(
                'name' => 'OTH SYS DROP',
                'parent_id' => 9,
            ),
            172 =>
            array(
                'name' => 'OTH SYS SOL',
                'parent_id' => 9,
            ),
            173 =>
            array(
                'name' => 'SUSP',
                'parent_id' => 9,
            ),
            174 =>
            array(
                'name' => 'SYR',
                'parent_id' => 9,
            ),
            175 =>
            array(
                'name' => 'SYR-RT',
                'parent_id' => 9,
            ),
            176 =>
            array(
                'name' => 'TOP DROPS',
                'parent_id' => 9,
            ),
            177 =>
            array(
                'name' => 'TOP DRY',
                'parent_id' => 9,
            ),
            178 =>
            array(
                'name' => 'TOP LIQ-U',
                'parent_id' => 9,
            ),
            179 =>
            array(
                'name' => 'TOP OIL',
                'parent_id' => 9,
            ),
            180 =>
            array(
                'name' => 'TOP SKIN',
                'parent_id' => 9,
            ),
            181 =>
            array(
                'name' => 'TOP SOL',
                'parent_id' => 9,
            ),
            182 =>
            array(
                'name' => 'TOP SPR',
                'parent_id' => 9,
            ),
            183 =>
            array(
                'name' => 'TOP SUSP',
                'parent_id' => 9,
            ),
            184 =>
            array(
                'name' => 'UNK LIQ',
                'parent_id' => 9,
            ),
            185 =>
            array(
                'name' => 'VG-EMULSION',
                'parent_id' => 9,
            ),
            186 =>
            array(
                'name' => 'VG-LOTION',
                'parent_id' => 9,
            ),
            187 =>
            array(
                'name' => 'VG-SOAP',
                'parent_id' => 9,
            ),
            188 =>
            array(
                'name' => 'VG-SOL',
                'parent_id' => 9,
            ),
            189 =>
            array(
                'name' => 'VG-SOL-U',
                'parent_id' => 9,
            ),
            190 =>
            array(
                'name' => 'BAND',
                'parent_id' => 10,
            ),
            191 =>
            array(
                'name' => 'COMB FRM',
                'parent_id' => 10,
            ),
            192 =>
            array(
                'name' => 'COTTON',
                'parent_id' => 10,
            ),
            193 =>
            array(
                'name' => 'D-OTH FRM',
                'parent_id' => 10,
            ),
            194 =>
            array(
                'name' => 'EY GAUZE',
                'parent_id' => 10,
            ),
            195 =>
            array(
                'name' => 'EY PADS',
                'parent_id' => 10,
            ),
            196 =>
            array(
                'name' => 'GAUZE',
                'parent_id' => 10,
            ),
            197 =>
            array(
                'name' => 'N-HUM GAUZE',
                'parent_id' => 10,
            ),
            198 =>
            array(
                'name' => 'ORAL SPONGE',
                'parent_id' => 10,
            ),
            199 =>
            array(
                'name' => 'OTH FRM-D',
                'parent_id' => 10,
            ),
            200 =>
            array(
                'name' => 'OTH MED DRESS',
                'parent_id' => 10,
            ),
            201 =>
            array(
                'name' => 'OTH VG DRESS',
                'parent_id' => 10,
            ),
            202 =>
            array(
                'name' => 'PADS',
                'parent_id' => 10,
            ),
            203 =>
            array(
                'name' => 'PLASTER',
                'parent_id' => 10,
            ),
            204 =>
            array(
                'name' => 'POULTICES',
                'parent_id' => 10,
            ),
            205 =>
            array(
                'name' => 'SPONGE',
                'parent_id' => 10,
            ),
            206 =>
            array(
                'name' => 'TAMPON',
                'parent_id' => 10,
            ),
            207 =>
            array(
                'name' => 'TRANS D-PATCH',
                'parent_id' => 10,
            ),
            208 =>
            array(
                'name' => 'TRANS D-SYS',
                'parent_id' => 10,
            ),
            209 =>
            array(
                'name' => 'VG TAMPON',
                'parent_id' => 10,
            ),
            210 =>
            array(
                'name' => 'BAND W/O',
                'parent_id' => 11,
            ),
            211 =>
            array(
                'name' => 'CEMENT',
                'parent_id' => 11,
            ),
            212 =>
            array(
                'name' => 'D-COLLOID',
                'parent_id' => 11,
            ),
            213 =>
            array(
                'name' => 'DIAG',
                'parent_id' => 11,
            ),
            214 =>
            array(
                'name' => 'EY DIAG',
                'parent_id' => 11,
            ),
            215 =>
            array(
                'name' => 'GAUZE W/O',
                'parent_id' => 11,
            ),
            216 =>
            array(
                'name' => 'N-HUM DIAG',
                'parent_id' => 11,
            ),
            217 =>
            array(
                'name' => 'N-HUM OTH DIAG',
                'parent_id' => 11,
            ),
            218 =>
            array(
                'name' => 'N-HUM OTH FRM',
                'parent_id' => 11,
            ),
            219 =>
            array(
                'name' => 'ORAL AID',
                'parent_id' => 11,
            ),
            220 =>
            array(
                'name' => 'OTH AID',
                'parent_id' => 11,
            ),
            221 =>
            array(
                'name' => 'OTH AID FRM',
                'parent_id' => 11,
            ),
            222 =>
            array(
                'name' => 'OTH EY FRM-O',
                'parent_id' => 11,
            ),
            223 =>
            array(
                'name' => 'OTH VG PES',
                'parent_id' => 11,
            ),
            224 =>
            array(
                'name' => 'PADS W/O',
                'parent_id' => 11,
            ),
            225 =>
            array(
                'name' => 'PLAST',
                'parent_id' => 11,
            ),
            226 =>
            array(
                'name' => 'SPONGE W/O',
                'parent_id' => 11,
            ),
            227 =>
            array(
                'name' => 'TAMPON W/O',
                'parent_id' => 11,
            ),
            228 =>
            array(
                'name' => 'TOP AID',
                'parent_id' => 11,
            ),
            229 =>
            array(
                'name' => 'COMB-OINT',
                'parent_id' => 12,
            ),
            230 =>
            array(
                'name' => 'D-OINT',
                'parent_id' => 12,
            ),
            231 =>
            array(
                'name' => 'D-OINT-U',
                'parent_id' => 12,
            ),
            232 =>
            array(
                'name' => 'D-PAST',
                'parent_id' => 12,
            ),
            233 =>
            array(
                'name' => 'EAR-OINT',
                'parent_id' => 12,
            ),
            234 =>
            array(
                'name' => 'EY-OINT',
                'parent_id' => 12,
            ),
            235 =>
            array(
                'name' => 'N-HUM PAST',
                'parent_id' => 12,
            ),
            236 =>
            array(
                'name' => 'NS-OINT',
                'parent_id' => 12,
            ),
            237 =>
            array(
                'name' => 'OINT-U',
                'parent_id' => 12,
            ),
            238 =>
            array(
                'name' => 'ORAL PAST',
                'parent_id' => 12,
            ),
            239 =>
            array(
                'name' => 'OTH OINT',
                'parent_id' => 12,
            ),
            240 =>
            array(
                'name' => 'RECT OINT',
                'parent_id' => 12,
            ),
            241 =>
            array(
                'name' => 'SYS OINT-U',
                'parent_id' => 12,
            ),
            242 =>
            array(
                'name' => 'TOP OINT',
                'parent_id' => 12,
            ),
            243 =>
            array(
                'name' => 'TOP PAST',
                'parent_id' => 12,
            ),
            244 =>
            array(
                'name' => 'VG-OINT',
                'parent_id' => 12,
            ),
            245 =>
            array(
                'name' => 'VG-OINT-U',
                'parent_id' => 12,
            ),
            246 =>
            array(
                'name' => 'BONE',
                'parent_id' => 13,
            ),
            247 =>
            array(
                'name' => 'CIGARETTES',
                'parent_id' => 13,
            ),
            248 =>
            array(
                'name' => 'CONE',
                'parent_id' => 13,
            ),
            249 =>
            array(
                'name' => 'D-CONE',
                'parent_id' => 13,
            ),
            250 =>
            array(
                'name' => 'D-FOAM',
                'parent_id' => 13,
            ),
            251 =>
            array(
                'name' => 'D-STICK',
                'parent_id' => 13,
            ),
            252 =>
            array(
                'name' => 'FOOD',
                'parent_id' => 13,
            ),
            253 =>
            array(
                'name' => 'IMPLNT',
                'parent_id' => 13,
            ),
            254 =>
            array(
                'name' => 'LIQ FOOD',
                'parent_id' => 13,
            ),
            255 =>
            array(
                'name' => 'MIX FOOD',
                'parent_id' => 13,
            ),
            256 =>
            array(
                'name' => 'NS ROLL',
                'parent_id' => 13,
            ),
            257 =>
            array(
                'name' => 'OTH VG FRM-U',
                'parent_id' => 13,
            ),
            258 =>
            array(
                'name' => 'PK',
                'parent_id' => 13,
            ),
            259 =>
            array(
                'name' => 'SOLID',
                'parent_id' => 13,
            ),
            260 =>
            array(
                'name' => 'SOLID FOOD',
                'parent_id' => 13,
            ),
            261 =>
            array(
                'name' => 'TOP STICK',
                'parent_id' => 13,
            ),
            262 =>
            array(
                'name' => 'UNK',
                'parent_id' => 13,
            ),
            263 =>
            array(
                'name' => 'VG-DEV',
                'parent_id' => 13,
            ),
            264 =>
            array(
                'name' => 'COMB-SYR',
                'parent_id' => 14,
            ),
            265 =>
            array(
                'name' => 'EY -SYR',
                'parent_id' => 14,
            ),
            266 =>
            array(
                'name' => 'IM-SYR',
                'parent_id' => 14,
            ),
            267 =>
            array(
                'name' => 'IM-SYR-RT',
                'parent_id' => 14,
            ),
            268 =>
            array(
                'name' => 'INJ',
                'parent_id' => 14,
            ),
            269 =>
            array(
                'name' => 'INJ-RT',
                'parent_id' => 14,
            ),
            270 =>
            array(
                'name' => 'I-SYR',
                'parent_id' => 14,
            ),
            271 =>
            array(
                'name' => 'I-SYR-RT',
                'parent_id' => 14,
            ),
            272 =>
            array(
                'name' => 'IV-SYR',
                'parent_id' => 14,
            ),
            273 =>
            array(
                'name' => 'OTH SYR',
                'parent_id' => 14,
            ),
            274 =>
            array(
                'name' => 'OTH SYR-RT',
                'parent_id' => 14,
            ),
            275 =>
            array(
                'name' => 'OTH TOP SYR',
                'parent_id' => 14,
            ),
            276 =>
            array(
                'name' => 'SC-SYR',
                'parent_id' => 14,
            ),
            277 =>
            array(
                'name' => 'SC-SYR-RT',
                'parent_id' => 14,
            ),
            278 =>
            array(
                'name' => 'SYR INS',
                'parent_id' => 14,
            ),
            279 =>
            array(
                'name' => 'SYR PWD',
                'parent_id' => 14,
            ),
            280 =>
            array(
                'name' => 'SYR PWD RT',
                'parent_id' => 14,
            ),
            281 =>
            array(
                'name' => 'TOP SYR',
                'parent_id' => 14,
            ),
            282 =>
            array(
                'name' => 'COMB LIQ PWD/GRAN',
                'parent_id' => 15,
            ),
            283 =>
            array(
                'name' => 'D-DUST PWD',
                'parent_id' => 15,
            ),
            284 =>
            array(
                'name' => 'D-GRAN',
                'parent_id' => 15,
            ),
            285 =>
            array(
                'name' => 'D-OTH PWD/GRAN',
                'parent_id' => 15,
            ),
            286 =>
            array(
                'name' => 'D-PWD',
                'parent_id' => 15,
            ),
            287 =>
            array(
                'name' => 'D-SOL PWD/GRAN',
                'parent_id' => 15,
            ),
            288 =>
            array(
                'name' => 'D-SOL PWD/GRAN -U',
                'parent_id' => 15,
            ),
            289 =>
            array(
                'name' => 'EFF PWD/GRAN',
                'parent_id' => 15,
            ),
            290 =>
            array(
                'name' => 'ENEM-PWD',
                'parent_id' => 15,
            ),
            291 =>
            array(
                'name' => 'LIQ PWD/GRAN',
                'parent_id' => 15,
            ),
            292 =>
            array(
                'name' => 'LUNG -PWD/GRAN',
                'parent_id' => 15,
            ),
            293 =>
            array(
                'name' => 'LUNG-INH N-REF',
                'parent_id' => 15,
            ),
            294 =>
            array(
                'name' => 'LUNG-INH REF',
                'parent_id' => 15,
            ),
            295 =>
            array(
                'name' => 'N-HUM GRAN',
                'parent_id' => 15,
            ),
            296 =>
            array(
                'name' => 'N-HUM PWD',
                'parent_id' => 15,
            ),
            297 =>
            array(
                'name' => 'N-HUM SOL',
                'parent_id' => 15,
            ),
            298 =>
            array(
                'name' => 'N-HUM SOLID',
                'parent_id' => 15,
            ),
            299 =>
            array(
                'name' => 'NS TOP-PWD',
                'parent_id' => 15,
            ),
            300 =>
            array(
                'name' => 'NS-PWD',
                'parent_id' => 15,
            ),
            301 =>
            array(
                'name' => 'ORAL GRAN-RT',
                'parent_id' => 15,
            ),
            302 =>
            array(
                'name' => 'ORAL GRANULES',
                'parent_id' => 15,
            ),
            303 =>
            array(
                'name' => 'ORAL PWD',
                'parent_id' => 15,
            ),
            304 =>
            array(
                'name' => 'ORAL PWD/GRAN',
                'parent_id' => 15,
            ),
            305 =>
            array(
                'name' => 'ORAL PWD/GRAN SUBL',
                'parent_id' => 15,
            ),
            306 =>
            array(
                'name' => 'ORAL PWD/GRAN -U',
                'parent_id' => 15,
            ),
            307 =>
            array(
                'name' => 'ORAL PWD/GRAN-RT',
                'parent_id' => 15,
            ),
            308 =>
            array(
                'name' => 'ORAL PWD/GRAN-URT',
                'parent_id' => 15,
            ),
            309 =>
            array(
                'name' => 'OTH LIQ PWD/GRAN',
                'parent_id' => 15,
            ),
            310 =>
            array(
                'name' => 'OTH SYS PWD',
                'parent_id' => 15,
            ),
            311 =>
            array(
                'name' => 'OTH SYS PWD/GRAN',
                'parent_id' => 15,
            ),
            312 =>
            array(
                'name' => 'PWD URF',
                'parent_id' => 15,
            ),
            313 =>
            array(
                'name' => 'SOL PWD/GRAN',
                'parent_id' => 15,
            ),
            314 =>
            array(
                'name' => 'SOL PWD/GRAN-RT',
                'parent_id' => 15,
            ),
            315 =>
            array(
                'name' => 'SOL PWD/GRAN-URT',
                'parent_id' => 15,
            ),
            316 =>
            array(
                'name' => 'SYS ENEM-PWD',
                'parent_id' => 15,
            ),
            317 =>
            array(
                'name' => 'TOP GRAN',
                'parent_id' => 15,
            ),
            318 =>
            array(
                'name' => 'TOP PWD',
                'parent_id' => 15,
            ),
            319 =>
            array(
                'name' => 'TOP SOL PWD',
                'parent_id' => 15,
            ),
            320 =>
            array(
                'name' => 'TOP SOL PWD-U',
                'parent_id' => 15,
            ),
            321 =>
            array(
                'name' => 'UNK -PWD',
                'parent_id' => 15,
            ),
            322 =>
            array(
                'name' => 'VG-PWD/GRAN',
                'parent_id' => 15,
            ),
            323 =>
            array(
                'name' => 'AERO',
                'parent_id' => 16,
            ),
            324 =>
            array(
                'name' => 'AERO-SYS',
                'parent_id' => 16,
            ),
            325 =>
            array(
                'name' => 'D-AERO',
                'parent_id' => 16,
            ),
            326 =>
            array(
                'name' => 'D-AERO COMB',
                'parent_id' => 16,
            ),
            327 =>
            array(
                'name' => 'D-AERO FOAM',
                'parent_id' => 16,
            ),
            328 =>
            array(
                'name' => 'D-AERO OIN',
                'parent_id' => 16,
            ),
            329 =>
            array(
                'name' => 'D-AERO PWD',
                'parent_id' => 16,
            ),
            330 =>
            array(
                'name' => 'D-AERO-U',
                'parent_id' => 16,
            ),
            331 =>
            array(
                'name' => 'EY-AERO',
                'parent_id' => 16,
            ),
            332 =>
            array(
                'name' => 'LUNG-INH',
                'parent_id' => 16,
            ),
            333 =>
            array(
                'name' => 'LUNG-INH CFC',
                'parent_id' => 16,
            ),
            334 =>
            array(
                'name' => 'LUNG-INH-MD',
                'parent_id' => 16,
            ),
            335 =>
            array(
                'name' => 'N-HUM AERO',
                'parent_id' => 16,
            ),
            336 =>
            array(
                'name' => 'NS-AERO',
                'parent_id' => 16,
            ),
            337 =>
            array(
                'name' => 'NS-AERO-U',
                'parent_id' => 16,
            ),
            338 =>
            array(
                'name' => 'NS-SYS AERO-U',
                'parent_id' => 16,
            ),
            339 =>
            array(
                'name' => 'R-SYS AERO',
                'parent_id' => 16,
            ),
            340 =>
            array(
                'name' => 'R-SYS FOAM',
                'parent_id' => 16,
            ),
            341 =>
            array(
                'name' => 'TOP AERO',
                'parent_id' => 16,
            ),
            342 =>
            array(
                'name' => 'TOP AERO-U',
                'parent_id' => 16,
            ),
            343 =>
            array(
                'name' => 'VG FOAM',
                'parent_id' => 16,
            ),
            344 =>
            array(
                'name' => 'COMB ORAL FRM',
                'parent_id' => 17,
            ),
            345 =>
            array(
                'name' => 'D-TOP OTH FRM',
                'parent_id' => 17,
            ),
            346 =>
            array(
                'name' => 'EYE SYST',
                'parent_id' => 17,
            ),
            347 =>
            array(
                'name' => 'GRANULES',
                'parent_id' => 17,
            ),
            348 =>
            array(
                'name' => 'LOZ',
                'parent_id' => 17,
            ),
            349 =>
            array(
                'name' => 'OTH FRM (CAKE)',
                'parent_id' => 17,
            ),
            350 =>
            array(
                'name' => 'OTH FRM (CUBES)',
                'parent_id' => 17,
            ),
            351 =>
            array(
                'name' => 'OTH FRM (GLOBUL)',
                'parent_id' => 17,
            ),
            352 =>
            array(
                'name' => 'OTH FRM (SWEET)',
                'parent_id' => 17,
            ),
            353 =>
            array(
                'name' => 'OTH LIQ ORAL',
                'parent_id' => 17,
            ),
            354 =>
            array(
                'name' => 'OTH ORAL FRM',
                'parent_id' => 17,
            ),
            355 =>
            array(
                'name' => 'OTH ORAL FRM-RT',
                'parent_id' => 17,
            ),
            356 =>
            array(
                'name' => 'OTH SYS TAB',
                'parent_id' => 17,
            ),
            357 =>
            array(
                'name' => 'TOP LOZ',
                'parent_id' => 17,
            ),
            358 =>
            array(
                'name' => 'TOP OTH FRM',
                'parent_id' => 17,
            ),
            359 =>
            array(
                'name' => 'TOP SWEET',
                'parent_id' => 17,
            ),
            360 =>
            array(
                'name' => 'COMB SUPP',
                'parent_id' => 18,
            ),
            361 =>
            array(
                'name' => 'MICRO ENEM',
                'parent_id' => 18,
            ),
            362 =>
            array(
                'name' => 'OTH SUPP',
                'parent_id' => 18,
            ),
            363 =>
            array(
                'name' => 'SUPP',
                'parent_id' => 18,
            ),
            364 =>
            array(
                'name' => 'SUPP AD',
                'parent_id' => 18,
            ),
            365 =>
            array(
                'name' => 'SUPP KID',
                'parent_id' => 18,
            ),
            366 =>
            array(
                'name' => 'TOP SUPP',
                'parent_id' => 18,
            ),
            367 =>
            array(
                'name' => 'TOP SUPP AD',
                'parent_id' => 18,
            ),
            368 =>
            array(
                'name' => 'TOP SUPP KID',
                'parent_id' => 18,
            ),
            369 =>
            array(
                'name' => 'VG COMB SUPP',
                'parent_id' => 18,
            ),
            370 =>
            array(
                'name' => 'VG SUPP',
                'parent_id' => 18,
            ),
            371 =>
            array(
                'name' => 'N-HUM SOL TAB',
                'parent_id' => 19,
            ),
            372 =>
            array(
                'name' => 'N-HUM TAB',
                'parent_id' => 19,
            ),
            373 =>
            array(
                'name' => 'N-HUM TAB EFF',
                'parent_id' => 19,
            ),
            374 =>
            array(
                'name' => 'TC-TAB',
                'parent_id' => 19,
            ),
            375 =>
            array(
                'name' => 'TC-TAB BUC',
                'parent_id' => 19,
            ),
            376 =>
            array(
                'name' => 'TC-TAB EFF',
                'parent_id' => 19,
            ),
            377 =>
            array(
                'name' => 'TC-TAB KIT',
                'parent_id' => 19,
            ),
            378 =>
            array(
                'name' => 'TC-TAB OD',
                'parent_id' => 19,
            ),
            379 =>
            array(
                'name' => 'TC-TAB SOLB',
                'parent_id' => 19,
            ),
            380 =>
            array(
                'name' => 'TC-TAB SUBL',
                'parent_id' => 19,
            ),
            381 =>
            array(
                'name' => 'VG-TAB',
                'parent_id' => 19,
            ),
            382 =>
            array(
                'name' => 'EXT TEA',
                'parent_id' => 20,
            ),
            383 =>
            array(
                'name' => 'INST TEAS',
                'parent_id' => 20,
            ),
            384 =>
            array(
                'name' => 'TEA',
                'parent_id' => 20,
            ),
            385 =>
            array(
                'name' => 'TEA BAG',
                'parent_id' => 20,
            ),
            386 =>
            array(
                'name' => 'COMB VIAL',
                'parent_id' => 21,
            ),
            387 =>
            array(
                'name' => 'D-OTH VIAL',
                'parent_id' => 21,
            ),
            388 =>
            array(
                'name' => 'D-PWD VIAL',
                'parent_id' => 21,
            ),
            389 =>
            array(
                'name' => 'D-VIAL',
                'parent_id' => 21,
            ),
            390 =>
            array(
                'name' => 'D-VIAL INS',
                'parent_id' => 21,
            ),
            391 =>
            array(
                'name' => 'EY-PWD VIAL',
                'parent_id' => 21,
            ),
            392 =>
            array(
                'name' => 'EY-VIAL',
                'parent_id' => 21,
            ),
            393 =>
            array(
                'name' => 'EY-VIAL INS',
                'parent_id' => 21,
            ),
            394 =>
            array(
                'name' => 'IM-VIAL',
                'parent_id' => 21,
            ),
            395 =>
            array(
                'name' => 'IM-VIAL RT',
                'parent_id' => 21,
            ),
            396 =>
            array(
                'name' => 'IV-VIAL',
                'parent_id' => 21,
            ),
            397 =>
            array(
                'name' => 'N-HUM VIAL',
                'parent_id' => 21,
            ),
            398 =>
            array(
                'name' => 'OTH VIAL',
                'parent_id' => 21,
            ),
            399 =>
            array(
                'name' => 'OTH VIAL RT',
                'parent_id' => 21,
            ),
            400 =>
            array(
                'name' => 'PWD VIAL',
                'parent_id' => 21,
            ),
            401 =>
            array(
                'name' => 'PWD VIAL RT',
                'parent_id' => 21,
            ),
            402 =>
            array(
                'name' => 'SC-VIAL',
                'parent_id' => 21,
            ),
            403 =>
            array(
                'name' => 'SC-VIAL RT',
                'parent_id' => 21,
            ),
            404 =>
            array(
                'name' => 'VIAL',
                'parent_id' => 21,
            ),
            405 =>
            array(
                'name' => 'VIAL RT',
                'parent_id' => 21,
            ),
            406 =>
            array(
                'name' => 'VIAL SKIN',
                'parent_id' => 21,
            ),
        );

        for ($i = 0; $i < count($childs); $i++) {
            $item = new ProductForm();
            $item->name = $childs[$i]['name'];
            $item->parent_id = $childs[$i]['parent_id'];
            $item->save();
        }

        // Additionals
        $item = new ProductForm();
        $item->name = 'SACHET';
        $item->save();

        $item = new ProductForm();
        $item->name = 'SOLUTION';
        $item->parent_id = 9;
        $item->save();

        $item = new ProductForm();
        $item->name = 'PATCHES';
        $item->save();

        $item = new ProductForm();
        $item->name = 'OVULES';
        $item->save();
    }
}
