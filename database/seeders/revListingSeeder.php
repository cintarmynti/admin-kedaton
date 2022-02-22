<?php

namespace Database\Seeders;

use App\Models\rev_listing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class revListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        rev_listing::create([
            'id' => 1,
            'cluster_id' => 2,
            'name' => 'Lukbre House',
            'diskon' => null,
            'status' => 'dijual',
            'properti_id' => 1,
            'harga' => number_format(12500000,2,',','.'),
            'image' => '/properti_photo/'.'16444074491056.png',
            'setelah_diskon' => 12000000,
        ]);

        rev_listing::create([
            'id' => 2,
            'cluster_id' => 1,
            'name' => 'Lukbre House',
            'diskon' => null,
            'status' => 'disewa',
            'properti_id' => 2,
            'harga' => number_format(43500000,2,',','.'),
            'image' => '/properti_photo/'.'16444075261251.png',
            'setelah_diskon' => 39000000,
        ]);

        rev_listing::create([
            'id' => 3,
            'cluster_id' => 1,
            'name' => 'Likey House',
            'diskon' => null,
            'status' => 'dijual',
            'properti_id' => 3,
            'harga' => number_format(70000000,2,',','.'),
            'image' => '/properti_photo/'.'16444075851990.png',
            'setelah_diskon' => 40500000,
        ]);

        rev_listing::create([
            'id' => 4,
            'cluster_id' => 3,
            'name' => 'Twice House',
            'diskon' => '15',
            'status' => 'dijual',
            'properti_id' => 4,
            'harga' => number_format(8200000,2,',','.'),
            'image' => '/properti_photo/'.'1644407727401.png',
            'setelah_diskon' => 8000000,
        ]);

        rev_listing::create([
            'id' => 5,
            'cluster_id' => 3,
            'name' => 'Fancy House',
            'diskon' => '20',
            'status' => 'dijual',
            'properti_id' => 5,
            'harga' => number_format(37200000,2,',','.'),
            'image' => '/properti_photo/'.'1644407816205.png',
            'setelah_diskon' => 32000000,
        ]);

        rev_listing::create([
            'id' => 6,
            'cluster_id' => 2,
            'name' => 'Vanila House',
            'diskon' => '20',
            'status' => 'dijual',
            'properti_id' => 6,
            'harga' => number_format(8200000,2,',','.'),
            'image' => '/properti_photo/'.'16445153461612.png',
            'setelah_diskon' => 72500000,
        ]);

        rev_listing::create([
            'id' => 7,
            'cluster_id' => 3,
            'name' => 'Taro House',
            'diskon' => '5',
            'status' => 'disewa',
            'properti_id' => 7,
            'harga' => number_format(13200000,2,',','.'),
            'image' => '/properti_photo/'.'16445154421213.png',
            'setelah_diskon' => 13000000,
        ]);


        rev_listing::create([
            'id' => 8,
            'cluster_id' => 2,
            'name' => 'Taro House',
            'diskon' => '5',
            'status' => 'disewa',
            'properti_id' => 8,
            'harga' => number_format(1100000,2,',','.'),
            'image' => '/properti_photo/'.'1644407816205.png',
            'setelah_diskon' => 10500000,
        ]);

        rev_listing::create([
            'id' => 9,
            'cluster_id' => 1,
            'name' => 'Sky House',
            'diskon' => null,
            'status' => 'dijual',
            'properti_id' => 9,
            'harga' => number_format(1500000,2,',','.'),
            'image' => '/properti_photo/'.'1644515768439.png',
            'setelah_diskon' => null
        ]);

        rev_listing::create([
            'id' => 10,
            'cluster_id' => 1,
            'name' => 'blue House',
            'diskon' => null,
            'status' => 'dijual',
            'properti_id' => 10,
            'harga' => 21000000,
            'image' => '/properti_photo/'.'16445158321696.png',
            'setelah_diskon' => null
        ]);


        // rev_listing::create([
        //     'id' => 11,
        //     'name' => 'charlie House',
        //     'diskon' => null,
        //     'status' => 'disewa',
        //     'properti_id' => 11,
        //     'harga' => 21000000,
        //     'image' => '/properti_photo/'.'1644407816205.png',
        //     'setelah_diskon' => null
        // ]);
    }
}

