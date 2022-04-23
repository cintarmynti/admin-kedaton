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
            // 'id' => 1,
            'name' => 'IPKL',
            'desc' => 'Bayar Tagihan IPKL'
        ]);

        type_pembayaran::create([
            // 'id' => 2,
            'name' => 'renovasi',
            'desc' => 'Bayar Renovasi'
        ]);


        type_pembayaran::create([
            // 'id' => 3,
            'name' => 'Internet',
            'desc' => 'Bayar Internet'
        ]);

        type_pembayaran::create([
            // 'id' => 4,
            'name' => 'PLN',
            'desc' => 'Bayar PLN'
        ]);
    }
}
