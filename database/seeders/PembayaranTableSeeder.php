<?php

namespace Database\Seeders;

use App\Models\IPKL;
use Illuminate\Database\Seeder;

class PembayaranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IPKL::create([
            'user_id' => 2,
            'tagihan_id' => 1,
            'periode_pembayaran' => '2022-02-08',
            'bank' => 'BCA',
            'bukti_tf' => null,
            'nominal' => '286750',
            'type' => 1,
            'status' => 1
        ]);

        IPKL::create([
            'user_id' => 2,
            'tagihan_id' => 2,
            'periode_pembayaran' => '2022-02-08',
            'bank' => 'BCA',
            'bukti_tf' => null,
            'nominal' => '286750',
            'type' => 1,
            'status' => 1
        ]);

        // IPKL::create([
        //     'user_id' => 2,
        //     'tagihan_id' => 3,
        //     'periode_pembayaran' => '2022-02-08',
        //     'bank' => 'BCA',
        //     'bukti_tf' => null,
        //     'nominal' => '286750',
        //     'type' => 1,
        //     'status' => 1
        // ]);

        // IPKL::create([
        //     'user_id' => 2,
        //     'tagihan_id' => 4,
        //     'periode_pembayaran' => '2022-02-08',
        //     'bank' => 'BCA',
        //     'bukti_tf' => null,
        //     'nominal' => '286750',
        //     'type' => 1,
        //     'status' => 1
        // ]);

        // IPKL::create([
        //     'user_id' => 2,
        //     'tagihan_id' => 5,
        //     'periode_pembayaran' => '2022-02-08',
        //     'bank' => 'BCA',
        //     'bukti_tf' => null,
        //     'nominal' => '286750',
        //     'type' => 1,
        //     'status' => 1
        // ]);
    }
}
