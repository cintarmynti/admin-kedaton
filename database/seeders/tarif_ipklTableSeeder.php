<?php

namespace Database\Seeders;

use App\Models\tarif_ipkl;
use Illuminate\Database\Seeder;

class tarif_ipklTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tarif_ipkl::create([
            'luas_kavling_awal' => 120,
            'luas_kavling_akhir' => 149,
            'tarif' => 1850
        ]);

        tarif_ipkl::create([
            'luas_kavling_awal' => 150,
            'luas_kavling_akhir' => 179,
            'tarif' => 1850
        ]);

        tarif_ipkl::create([
            'luas_kavling_awal' => 180,
            'luas_kavling_akhir' => 199,
            'tarif' => 1800
        ]);


        tarif_ipkl::create([
            'luas_kavling_awal' => 200,
            'luas_kavling_akhir' => 239,
            'tarif' => 1800
        ]);

        tarif_ipkl::create([
            'luas_kavling_awal' => 240,
            'luas_kavling_akhir' => 299,
            'tarif' => 1750
        ]);

        tarif_ipkl::create([
            'luas_kavling_awal' => 300,
            'luas_kavling_akhir' => 359,
            'tarif' => 1750
        ]);

        tarif_ipkl::create([
            'luas_kavling_awal' => 360,
            'luas_kavling_akhir' => null,
            'tarif' => 1700
        ]);

    }
}
