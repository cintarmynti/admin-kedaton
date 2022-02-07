<?php

namespace Database\Seeders;

use App\Models\Properti;
use Illuminate\Database\Seeder;

class PropertiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Properti::create([
           'user_id' => 2,
           'cluster_id' => 1,
           'no_rumah' => 21,
           'no_listrik' => '38432874923',
           'no_pam_bsd' => '47883749',
           'penghuni_id' => 5
        ]);


        Properti::create([
            'user_id' => 3,
            'cluster_id' => 1,
            'no_rumah' => 40,
            'no_listrik' => '38432874923',
            'no_pam_bsd' => '47883749',
            'penghuni_id' => 6
         ]);

         Properti::create([
            'user_id' => 4,
            'cluster_id' => 2,
            'no_rumah' => 32,
            'no_listrik' => '38432487523',
            'no_pam_bsd' => '473883749'
         ]);
    }
}
