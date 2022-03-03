<?php

namespace Database\Seeders;

use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TagihanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tagihan::create([
            'id' => 1,
            'cluster_id' => 1,
            'properti_id' => 1,
            'periode_pembayaran' => Carbon::parse('2022-03-01'),
            'jumlah_pembayaran' => '286750',
            'status' => 1,
            'type_id' => 2
        ]);

        Tagihan::create([
            'id' => 2,
            'cluster_id' => 1,
            'properti_id' => 1,
            'periode_pembayaran' => Carbon::parse('2022-04-01'),
            'jumlah_pembayaran' => '286750',
            'status' => 1,
            'type_id' => 2
        ]);

        Tagihan::create([
            'id' => 3,
            'cluster_id' => 1,
            'properti_id' => 1,
            'periode_pembayaran' => Carbon::parse('2022-05-01'),
            'jumlah_pembayaran' => '286750',
            'status' => 1,
            'type_id' => 1
        ]);

        // Tagihan::create([
        //     'id' => 4,
        //     'cluster_id' => 1,
        //     'properti_id' => 1,
        //     'periode_pembayaran' => Carbon::now(),
        //     'jumlah_pembayaran' => '286750',
        //     'status' => 1,
        //     'type_id' => 2
        // ]);

        // Tagihan::create([
        //     'id' => 5,
        //     'cluster_id' => 1,
        //     'properti_id' => 1,
        //     'periode_pembayaran' => Carbon::now(),
        //     'jumlah_pembayaran' => '286750',
        //     'status' => 1,
        //     'type_id' => 2
        // ]);
    }
}
