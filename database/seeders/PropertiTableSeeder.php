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
           'pemilik_id' => null,
           'cluster_id' => 1,
           'no_rumah' => 21,
           'no_listrik' => '38432874923',
           'no_pam_bsd' => '47883749',
           'penghuni_id' => null,
           'alamat' => 'medokan ayu',
            'RT' => '003',
            'RW' => '006',
            'lantai' => 2,
            'jumlah_kamar' => 6,
            'luas_tanah' => 155,
            'luas_bangunan' => 30,
            'tarif_ipkl' => '286750',
            'status' => null,
            'provinsi' => 'jawa tengah',
            'kabupaten' => 'semarang',
            'kecamatan' => 'mijen',
            'kelurahan' => 'pesantren',
            'kamar_mandi' => 2,
            'carport' => 1
        ]);

        Properti::create([
            'pemilik_id' => null,
            'cluster_id' => 1,
            'no_rumah' => 17,
            'no_listrik' => '437934027',
            'no_pam_bsd' => '029887323',
            'penghuni_id' => null,
            'alamat' => 'semampir',
             'RT' => '021',
             'RW' => '016',
             'lantai' => 1,
             'jumlah_kamar' => 3,
             'luas_tanah' => 186,
             'luas_bangunan' => 40,
             'tarif_ipkl' => '286750',
             'provinsi' => 'jawa tengah',
             'kabupaten' => 'semarang',
             'kecamatan' => 'mijen',
             'kelurahan' => 'pesantren',
             'status' => null,
             'kamar_mandi' => 2,
             'carport' => 1
         ]);


        Properti::create([
            'pemilik_id' => null,
            'cluster_id' => 1,
            'no_rumah' => 40,
            'no_listrik' => '38432874923',
            'no_pam_bsd' => '47883749',
            'penghuni_id' => null,
            'alamat' => 'wonokromo',
            'RT' => '008',
            'RW' => '007',
            'lantai' => null,
            'jumlah_kamar' => 3,
            'luas_tanah' => 150,
            'luas_bangunan' => null,
            'tarif_ipkl' => '286750',
            'status' => 'dihuni',
            // 'harga' => null,
            'kamar_mandi' => 2,
            'carport' => 1
         ]);

        //  Properti::create([
        //     'pemilik_id' => 2,
        //     'cluster_id' => 2,
        //     'no_rumah' => 32,
        //     'no_listrik' => '38432487523',
        //     'no_pam_bsd' => '473883749',
        //     'alamat' => 'medaeng',
        //     'RT' => 003,
        //     'RW' => 003,
        //     'lantai' => null,
        //     'jumlah_kamar' => 3,
        //     'luas_tanah' => 150,
        //     'luas_bangunan' => null,
        //     'tarif_ipkl' => '286750',
        //     'status' => 'dijual',
        //     'harga' => null

        //  ]);

        //  Properti::create([
        //     'pemilik_id' => 4,
        //     'cluster_id' => 1,
        //     'no_rumah' => 28,
        //     'no_listrik' => '38432874923',
        //     'no_pam_bsd' => '47883749',
        //     'penghuni_id' => 5,
        //     'alamat' => 'medokan ayu',
        //      'RT' => '003',
        //      'RW' => '006',
        //      'lantai' => 2,
        //      'jumlah_kamar' => 6,
        //      'luas_tanah' => 155,
        //      'luas_bangunan' => 30,
        //      'tarif_ipkl' => '286750',
        //      'status' => 'disewakan',
        //      'harga' => null,
        //      'kamar_mandi' => 2,
        //      'carport' => 1
        //  ]);


        //  Properti::create([
        //      'pemilik_id' => null,
        //      'cluster_id' => 1,
        //      'no_rumah' => 43,
        //      'no_listrik' => '38432874923',
        //      'no_pam_bsd' => '47883749',
        //      'penghuni_id' => null,
        //      'alamat' => 'wonokromo',
        //      'RT' => '001',
        //      'RW' => '002',
        //      'lantai' => 2,
        //      'jumlah_kamar' => 3,
        //      'luas_tanah' => 150,
        //      'luas_bangunan' => null,
        //      'tarif_ipkl' => '286750',
        //      'status' => 'dihuni',
        //      'harga' => null,
        //      'kamar_mandi' => 2,
        //      'carport' => 1
        //   ]);

        //   Properti::create([
        //      'pemilik_id' => 3,
        //      'cluster_id' => 2,
        //      'no_rumah' => 68,
        //      'no_listrik' => '38432487523',
        //      'no_pam_bsd' => '473883749',
        //      'alamat' => 'medaeng',
        //      'RT' => '010',
        //      'RW' => '020',
        //      'lantai' => 2,
        //      'jumlah_kamar' => 3,
        //      'luas_tanah' => 150,
        //      'luas_bangunan' => null,
        //      'tarif_ipkl' => '286750',
        //      'status' => 'dijual',
        //      'harga' => null

        //   ]);

        //   Properti::create([
        //     'pemilik_id' => null,
        //     'cluster_id' => 1,
        //     'no_rumah' => 78,
        //     'no_listrik' => '38432874923',
        //     'no_pam_bsd' => '47883749',
        //     'penghuni_id' => 2,
        //     'alamat' => 'medokan ayu',
        //      'RT' => '003',
        //      'RW' => '006',
        //      'lantai' => 2,
        //      'jumlah_kamar' => 6,
        //      'luas_tanah' => 155,
        //      'luas_bangunan' => 30,
        //      'tarif_ipkl' => '286750',
        //      'status' => 'disewakan',
        //      'harga' => null,
        //      'kamar_mandi' => 2,
        //      'carport' => 1
        //  ]);


        //  Properti::create([
        //      'pemilik_id' => null,
        //      'cluster_id' => 1,
        //      'no_rumah' => 64,
        //      'no_listrik' => '38432874923',
        //      'no_pam_bsd' => '47883749',
        //      'penghuni_id' => 2,
        //      'alamat' => 'wonokromo',
        //      'RT' => '012',
        //      'RW' => '071',
        //      'lantai' => 2,
        //      'jumlah_kamar' => 3,
        //      'luas_tanah' => 150,
        //      'luas_bangunan' => null,
        //      'tarif_ipkl' => '286750',
        //      'status' => 'dihuni',
        //      'harga' => null,
        //      'kamar_mandi' => 2,
        //      'carport' => 1
        //   ]);

        //   Properti::create([
        //      'pemilik_id' => null,
        //      'cluster_id' => 2,
        //      'no_rumah' => 55,
        //      'no_listrik' => '38432487523',
        //      'no_pam_bsd' => '473883749',
        //      'alamat' => 'medaeng',
        //      'RT' => '050',
        //      'RW' => '090',
        //      'lantai' => 2,
        //      'jumlah_kamar' => 3,
        //      'luas_tanah' => 150,
        //      'luas_bangunan' => null,
        //      'tarif_ipkl' => '286750',
        //      'status' => 'dijual',
        //      'harga' => null

        //   ]);

        //   Properti::create([
        //     'pemilik_id' => null,
        //     'cluster_id' => 1,
        //     'no_rumah' => 17,
        //     'no_listrik' => '38432874923',
        //     'no_pam_bsd' => '47883749',
        //     'penghuni_id' => null,
        //     'alamat' => 'medokan ayu',
        //      'RT' => '003',
        //      'RW' => '006',
        //      'lantai' => 2,
        //      'jumlah_kamar' => 6,
        //      'luas_tanah' => 155,
        //      'luas_bangunan' => 30,
        //      'tarif_ipkl' => '286750',
        //      'status' => 'disewakan',
        //      'harga' => null,
        //      'kamar_mandi' => 2,
        //      'carport' => 1
        //  ]);


    }
}
