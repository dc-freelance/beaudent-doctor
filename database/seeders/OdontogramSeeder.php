<?php

namespace Database\Seeders;

use App\Models\Odontogram;
use Illuminate\Database\Seeder;

class OdontogramSeeder extends Seeder
{
    public function run(): void
    {
        $odontograms = [
            [
                'name' => 'Sound',
                'symbol' => 'sou',
                'description' => 'Gigi sehat, normal, dan tanpa kelainan',
            ],
            [
                'name' => 'No Information',
                'symbol' => 'nou',
                'description' => 'Tidak diketahui informasi tentang gigi tersebut',
            ],
            [
                'name' => 'Unerupted',
                'symbol' => 'une',
                'description' => 'Gigi tidak/belum erupsi.',
            ],
            [
                'name' => 'Partial Erupted',
                'symbol' => 'pre',
                'description' => 'Gigi terlihat sebagian atau belum tumbuh sempurna.',
            ],
            [
                'name' => 'Present',
                'symbol' => 'pres',
                'description' => 'Gigi terlihat ada',
            ],
            [
                'name' => 'Impacted non Visible',
                'symbol' => 'imx',
                'description' => 'Gigi impaksi tidak terlihat secara klinis',
            ],
            [
                'name' => 'Anomali',
                'symbol' => 'ano',
                'description' => 'Gigi mengalami kelainan anatomis atau morfologis',
            ],
            [
                'name' => 'Diastema',
                'symbol' => 'dia',
                'description' => 'Gigi renggang/terdapat celah dalam relasi mesial dan/atau distal',
            ],
            [
                'name' => 'Attrition',
                'symbol' => '',
                'description' => 'Gigi mengalami keausan di mahkota karena gesekan',
            ],
            [
                'name' => 'Carries',
                'symbol' => 'car',
                'description' => 'Gigi mengalami karies/terdapat lubang pada gigi',
            ],
            [
                'name' => 'Crown Factured',
                'symbol' => 'cfr',
                'description' => 'Fraktur pada mahkota gigi',
            ],
            [
                'name' => 'Non Vital Tooth',
                'symbol' => 'nvt',
                'description' => 'Gigi non vital karena perubahan warna mahkota atau dari radiograf',
            ],
            [
                'name' => 'Root Canal Treatment',
                'symbol' => 'rct',
                'description' => 'Gigi telah atau sedang menjalani perawatan saluran akar',
            ],
            [
                'name' => 'Retainer Root',
                'symbol' => 'rrx',
                'description' => 'Sisa akar gigi',
            ],
            [
                'name' => 'Missing',
                'symbol' => 'mis',
                'description' => 'Gigi dicabut sampai akar dengan alasan patologis maupun perawatan',
            ],
            [
                'name' => 'Missing ante Mortem',
                'symbol' => 'mam',
                'description' => 'Gigi dicabut sampai akar dengan alasan patologis maupun perawatan',
            ],
            [
                'name' => 'Missing post Mortem',
                'symbol' => 'mpm',
                'description' => 'Gigi tercabut sampai akar setelah kematian',
            ],
            [
                'name' => 'Amalgam Filling',
                'symbol' => 'amf',
                'description' => 'Tumpatan/tambalan amalgam',
            ],
            [
                'name' => 'Glass Ionomer Filling',
                'symbol' => 'gif',
                'description' => 'Tumpatan/tambalan GIC sewarna gigi',
            ],
            [
                'name' => 'Fissure Sealant',
                'symbol' => 'fis',
                'description' => 'Tumpatan/tambalan komposit/GIC sewarna gigi yang digunakan untuk menutupi pit dan fissure pada gigi yang sehat',
            ],
            [
                'name' => 'In (Inlay)',
                'symbol' => 'inl',
                'description' => 'Terdapat restorasi inlay atau onlay pada gigi',
            ],
            [
                'name' => 'On (Onlay)',
                'symbol' => 'onl',
                'description' => 'Terdapat restorasi inlay atau onlay pada gigi',
            ],
            [
                'name' => 'Full metal crown',
                'symbol' => 'fmcs',
                'description' => 'Terdapat restorasi mahkota logam secara keseluruhan',
            ],
            [
                'name' => 'Porcelain Crown',
                'symbol' => 'poc',
                'description' => 'Terdapat restorasi mahkota porcelen/keramik',
            ],
            [
                'name' => 'Metal Porcelain Crown',
                'symbol' => 'mpc',
                'description' => 'Terdapat restorasi mahkota porcelain/keramik diperkuat logam',
            ],
            [
                'name' => 'Gold Porcelain Crown',
                'symbol' => 'gmc',
                'description' => 'Terdapat restorasi mahkota porcelain/keramik diperkuat logam emas',
            ],
            [
                'name' => 'Implant',
                'symbol' => 'ipx',
                'description' => 'Implan gigi',
            ],
            [
                'name' => 'Metal Bridge',
                'symbol' => 'meb',
                'description' => 'Restorasi jembatan selain dari bahan tidak sewarna gigi',
            ],
            [
                'name' => 'Porcelain Bridge',
                'symbol' => 'pob',
                'description' => 'Restorasi jembatan yang terbuat dari porselen atau bahan sewarna gigi',
            ],
            [
                'name' => 'Pontic',
                'symbol' => 'pon',
                'description' => 'Mahkota gigi yang menggantikan gigi asli yang telah dicabut/tidak ada.',
            ],
            [
                'name' => 'Abutment',
                'symbol' => 'abu',
                'description' => 'Gigi penjangkar/penyangga restorasi jembatan',
            ],
            [
                'name' => 'Partial Denture',
                'symbol' => 'prd',
                'description' => 'Gigi tiruan sebagian lepasan',
            ],
            [
                'name' => 'Full Denture',
                'symbol' => 'fld',
                'description' => 'Gigi tiruan lengkap',
            ],
            [
                'name' => 'Acrylic',
                'symbol' => 'acr',
                'description' => 'Gigi tiruan bahan keramik',
            ],
        ];

        Odontogram::insert($odontograms);
    }
}
