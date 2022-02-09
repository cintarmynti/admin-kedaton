<?php

namespace Database\Seeders;

use App\Models\type_pembayaran;
use Illuminate\Database\Seeder;

class typePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        type_pembayaran::create([

            'name' => 'IPKL'
        ]);

        type_pembayaran::create([

            'name' => 'layanan'
        ]);
    }
}
