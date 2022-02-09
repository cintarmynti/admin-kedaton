<?php

namespace Database\Seeders;

use App\Models\layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        layanan::create([
           'id' => 1,
           'nama' => 'Memotong Rumput',
           'harga' => '50000'
        ]);

        layanan::create([
            'id' => 2,
            'nama' => 'Membersihkan Halaman',
            'harga' => '50000'

         ]);
    }
}
