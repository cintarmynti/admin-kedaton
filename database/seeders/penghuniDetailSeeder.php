<?php

namespace Database\Seeders;

use App\Models\penghuniDetail;
use Illuminate\Database\Seeder;

class penghuniDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        penghuniDetail::create([
            'penghuni_id' => 3,
            'properti_id' => 1
        ]);

        penghuniDetail::create([
            'penghuni_id' => 4,
            'properti_id' => 1
        ]);

        penghuniDetail::create([
            'penghuni_id' => 5,
            'properti_id' => 1
        ]);
    }
}
