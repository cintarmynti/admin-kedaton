<?php

namespace Database\Seeders;

use App\Models\PanicButton;
use Illuminate\Database\Seeder;

class PanicButtonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PanicButton::create([
           'user_id' => 2,
           'id_rumah' => 2,
           'keterangan' => 'sedang tidak baik baik saja',
           'status_keterangan' => 'checked'
        ]);

        PanicButton::create([
            'user_id' => 2,
            'id_rumah' => 2,
            'keterangan' => 'maling',
            'status_keterangan' => 'not checked'
         ]);
    }
}
