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
           'pemilik_id' => 2,
           'cluster_id' => 1,
           'no_rumah' => 21,
           'no_listrik' => '38432874923',
           'no_pam_bsd' => '47883749',
           'penghuni_id' => 5,
           'alamat' => 'medokan ayu',
            'RT' => '003',
            'RW' => '006',
            'lantai' => 2,
            'jumlah_kamar' => 6,
            'luas_tanah' => 155,
            'luas_bangunan' => 30,
            'tarif_ipkl' => '286750',
            'status' => 'disewakan',
            'harga' => null,
            'kamar_mandi' => 2,
            'carport' => 1
        ]);


        Properti::create([
            'pemilik_id' => 3,
            'cluster_id' => 1,
            'no_rumah' => 40,
            'no_listrik' => '38432874923',
            'no_pam_bsd' => '47883749',
            'penghuni_id' => 6,
            'alamat' => 'wonokromo',
            'RT' => null,
            'RW' => null,
            'lantai' => null,
            'jumlah_kamar' => null,
            'luas_tanah' => null,
            'luas_bangunan' => null,
            'tarif_ipkl' => null,
            'status' => 'dihuni',
            'harga' => null,
            'kamar_mandi' => 2,
            'carport' => 1
         ]);

         Properti::create([
            'pemilik_id' => 2,
            'cluster_id' => 2,
            'no_rumah' => 32,
            'no_listrik' => '38432487523',
            'no_pam_bsd' => '473883749',
            'alamat' => 'medaeng',
            'RT' => null,
            'RW' => null,
            'lantai' => null,
            'jumlah_kamar' => null,
            'luas_tanah' => null,
            'luas_bangunan' => null,
            'tarif_ipkl' => null,
            'status' => 'dijual',
            'harga' => null

         ]);

         Properti::create([
            'pemilik_id' => 4,
            'cluster_id' => 1,
            'no_rumah' => 28,
            'no_listrik' => '38432874923',
            'no_pam_bsd' => '47883749',
            'penghuni_id' => 5,
            'alamat' => 'medokan ayu',
             'RT' => '003',
             'RW' => '006',
             'lantai' => 2,
             'jumlah_kamar' => 6,
             'luas_tanah' => 155,
             'luas_bangunan' => 30,
             'tarif_ipkl' => '286750',
             'status' => 'disewakan',
             'harga' => null,
             'kamar_mandi' => 2,
             'carport' => 1
         ]);


         Properti::create([
             'pemilik_id' => 3,
             'cluster_id' => 1,
             'no_rumah' => 43,
             'no_listrik' => '38432874923',
             'no_pam_bsd' => '47883749',
             'penghuni_id' => 6,
             'alamat' => 'wonokromo',
             'RT' => null,
             'RW' => null,
             'lantai' => null,
             'jumlah_kamar' => null,
             'luas_tanah' => null,
             'luas_bangunan' => null,
             'tarif_ipkl' => null,
             'status' => 'dihuni',
             'harga' => null,
             'kamar_mandi' => 2,
             'carport' => 1
          ]);

          Properti::create([
             'pemilik_id' => 3,
             'cluster_id' => 2,
             'no_rumah' => 68,
             'no_listrik' => '38432487523',
             'no_pam_bsd' => '473883749',
             'alamat' => 'medaeng',
             'RT' => null,
             'RW' => null,
             'lantai' => null,
             'jumlah_kamar' => null,
             'luas_tanah' => null,
             'luas_bangunan' => null,
             'tarif_ipkl' => null,
             'status' => 'dijual',
             'harga' => null

          ]);

          Properti::create([
            'pemilik_id' => 7,
            'cluster_id' => 1,
            'no_rumah' => 78,
            'no_listrik' => '38432874923',
            'no_pam_bsd' => '47883749',
            'penghuni_id' => 5,
            'alamat' => 'medokan ayu',
             'RT' => '003',
             'RW' => '006',
             'lantai' => 2,
             'jumlah_kamar' => 6,
             'luas_tanah' => 155,
             'luas_bangunan' => 30,
             'tarif_ipkl' => '286750',
             'status' => 'disewakan',
             'harga' => null,
             'kamar_mandi' => 2,
             'carport' => 1
         ]);


         Properti::create([
             'pemilik_id' => 6,
             'cluster_id' => 1,
             'no_rumah' => 64,
             'no_listrik' => '38432874923',
             'no_pam_bsd' => '47883749',
             'penghuni_id' => 6,
             'alamat' => 'wonokromo',
             'RT' => null,
             'RW' => null,
             'lantai' => null,
             'jumlah_kamar' => null,
             'luas_tanah' => null,
             'luas_bangunan' => null,
             'tarif_ipkl' => null,
             'status' => 'dihuni',
             'harga' => null,
             'kamar_mandi' => 2,
             'carport' => 1
          ]);

          Properti::create([
             'pemilik_id' => 5,
             'cluster_id' => 2,
             'no_rumah' => 55,
             'no_listrik' => '38432487523',
             'no_pam_bsd' => '473883749',
             'alamat' => 'medaeng',
             'RT' => null,
             'RW' => null,
             'lantai' => null,
             'jumlah_kamar' => null,
             'luas_tanah' => null,
             'luas_bangunan' => null,
             'tarif_ipkl' => null,
             'status' => 'dijual',
             'harga' => null

          ]);

          Properti::create([
            'pemilik_id' => 4,
            'cluster_id' => 1,
            'no_rumah' => 17,
            'no_listrik' => '38432874923',
            'no_pam_bsd' => '47883749',
            'penghuni_id' => 5,
            'alamat' => 'medokan ayu',
             'RT' => '003',
             'RW' => '006',
             'lantai' => 2,
             'jumlah_kamar' => 6,
             'luas_tanah' => 155,
             'luas_bangunan' => 30,
             'tarif_ipkl' => '286750',
             'status' => 'disewakan',
             'harga' => null,
             'kamar_mandi' => 2,
             'carport' => 1
         ]);


    }
}
