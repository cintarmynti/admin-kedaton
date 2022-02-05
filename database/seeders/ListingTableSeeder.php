<?php

namespace Database\Seeders;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class ListingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Listing::create([
            'id' => 1,
            'alamat' => 'kendangsari',
            'no_rumah' => 21,
            'RT'=> 03,
            'RW' => 1,
            'lantai' => 3,
            'jumlah_kamar' => 5,
            'luas_tanah' => 155,
            'luas_bangunan' => 20,
            'user_id_penghuni' => 2,
            'user_id_pemilik' => 7,
            'tarif_ipkl' => 12000,
            'status' => 'dijual',
            'cluster_id' => 1,
            'harga' => 50000000,
        ]);


        Listing::create([
            'id' => 2,
            'alamat' => 'tenggilis mejoyo',
            'no_rumah' => 50,
            'RT'=> 12,
            'RW' => 8,
            'lantai' => 10,
            'jumlah_kamar' => '5',
            'luas_tanah' => '155',
            'luas_bangunan' => '20',
            'user_id_penghuni' => 2,
            'user_id_pemilik' => 7,
            'tarif_ipkl' => 400000,
            'status' => 'dijual',
            'cluster_id' => 2,
            'harga' => 50000000,
        ]);

        Listing::create([
            'id' => 3,
            'alamat' => 'sidoarjo',
            'no_rumah' => 110,
            'RT'=> 9,
            'RW' => 7,
            'lantai' => 4,
            'jumlah_kamar' => '3',
            'luas_tanah' => '155',
            'luas_bangunan' => '20',
            'user_id_penghuni' => 2,
            'user_id_pemilik' => 7,
            'tarif_ipkl' => 400000,
            'status' => 'dijual',
            'cluster_id' => 3,
            'harga' => 50000000,
        ]);


        Listing::create([
            'id' => 4,
            'alamat' => 'wonorejo',
            'no_rumah' => 141,
            'RT'=> 2,
            'RW' => 3,
            'lantai' => '3',
            'jumlah_kamar' => '5',
            'luas_tanah' => '155',
            'luas_bangunan' => '20',
            'user_id_penghuni' => 2,
            'user_id_pemilik' => 7,
            'tarif_ipkl' => 12000,
            'status' => 'dijual',
            'cluster_id' => 1,
            'harga' => 50000000,
        ]);


        Listing::create([
            'id' => 5,
            'alamat' => 'medokan ayu',
            'no_rumah' => 172,
            'RT'=> 6,
            'RW' => 6,
            'lantai' => '3',
            'jumlah_kamar' => '5',
            'luas_tanah' => '155',
            'luas_bangunan' => '20',
            'user_id_penghuni' => 2,
            'user_id_pemilik' => 7,
            'tarif_ipkl' => 12000,
            'status' => 'dijual',
            'cluster_id' => 2,
            'harga' => 50000000,
        ]);




    }
}
